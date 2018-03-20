<?php

namespace App\Http\Controllers\Root;

use App\Notifications\{ResourceCreated, ResourceUpdated, ResourceDeleted};
use App\{Coupon, User};
use ImageUploader;
use File, URL;
use Carbon, Image, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsController extends Controller
{
    protected $superusers;

    public function __construct()
    {
        $this->superusers = User::where('type', 'superuser')->get();
    }

    public function index()
    {
        $coupon = Coupon::all();

        return view('root.coupons.index', ['coupons' => $coupon]);
    }

    public function create()
    {
        return view('root.coupons.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|unique:categories,name,NULL,id,deleted_at,NULL',
            'description'   => 'max:500',
            'amount_deductable'   => 'required',
            'valid_from' => 'required',
            'valid_until' => 'required',
        ]);

        try {
            $coupon = new Coupon;

            $coupon->name         = $request->input('name');
            $coupon->description  = $request->input('description');
            $coupon->amount_deductable  = $request->input('amount_deductable');            
            $coupon->valid_from  = $request->input('valid_from');
            $coupon->valid_until  = $request->input('valid_until');

            if ($coupon->save()) {
                $this->superusers->each(function($notifiable) use ($coupon) {
                    $notifiable->notify(
                        new ResourceCreated(
                            auth()->user(), $coupon, route('root.coupons.edit', $coupon)
                        )
                    );
                });

                Notify::success('Coupon created.', 'Success!');

                return redirect()->route('root.coupons.image', $coupon);
            }

            Notify::warning('Cannot create a coupon', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }
    public function edit(Coupon $coupon)
    {
        return view('root.coupons.edit', ['coupons' => $coupon]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->validate($request, [
            'name'          => 'required|unique:categories,name,NULL,id,deleted_at,NULL',
            'description'   => 'max:500',
            'amount_deductable'   => 'required',
            'valid_from' => 'required',
            'valid_until' => 'required',
        ]);

        try {
            $coupon->name         = $request->input('name');
            $coupon->description  = $request->input('description');
            $coupon->amount_deductable  = $request->input('amount_deductable');            
            $coupon->valid_from  = $request->input('valid_from');
            $coupon->valid_until  = $request->input('valid_until');

            if ($coupon->save()) {
                $this->superusers->each(function($notifiable) use ($coupon) {
                    $notifiable->notify(
                        new ResourceUpdated(
                            auth()->user(), $coupon, route('root.coupons.edit', $coupon)
                        )
                    );
                });

                Notify::success('Coupon updated.', 'Success!');

                return redirect()->route('root.coupons.index');
            }

            Notify::warning('Cannot update coupon', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function destroy(Coupon $coupon)
    {
        try {
            if ($coupon->delete()) {
                $this->superusers->each(function($notifiable) use ($coupon) {
                    $notifiable->notify(
                        new ResourceDeleted(
                            auth()->user(), $coupon, route('root.coupon.index')
                        )
                    );
                });

                Notify::success('Coupon deleted.', 'Success!');

                return redirect()->back();
            }

            Notify::warning('Cannot delete coupon', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function toggle(Coupon $coupon)
    {
        try {
            $active = $coupon->active ? false : true;

            $coupon->active = $active;

            if ($coupon->save()) {
                $coupon->coupon->map(function($coupon) use ($active) {
                    $coupon->active = $active;
                    $coupon->save();
                });

                $this->superusers->each(function($notifiable) use ($coupon) {
                    $notifiable->notify(
                        new ResourceUpdated(
                            auth()->user(), $coupon, route('root.coupons.edit', $coupon)
                        )
                    );
                });

                Notify::success('Coupon toggled.', 'Success!');

                return redirect()->back();
            }

            Notify::warning('Cannot toggle coupon', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }
    public function selectImage(Coupon $coupon)
    {
        try {
            if ($coupon != null) {
                return view('root.coupons.image', ['coupons' => $coupon]);
            }

            Notify::warning('Cannot find coupon', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function uploadedImage(Request $request, Coupon $coupon)
    {
        $thumbs_directory = $coupon->file_directory.'/thumbnails';

        if (File::exists($thumbs_directory.'/'.$coupon->file_name)) {
            $file_path = $thumbs_directory.'/'.$coupon->file_name;

            $images = [
                [
                    'directory' => URL::to($thumbs_directory),
                    'name'      => File::name($file_path).'.'.File::extension($file_path),
                    'size'      => File::size($file_path)
                ]
            ];

            return response()->json(['images' => $images]);
        }

        return response()->json('No image.');
    }

    public function uploadImage(Request $request, Coupon $coupon)
    {
        try {
            $upload = ImageUploader::upload($request->file('image'), "categories/{$coupon->id}");

            $coupon->file_path = $upload['file_path'];
            $coupon->file_directory = $upload['file_directory'];
            $coupon->file_name = $upload['file_name'];

            if ($coupon->save()) {
                return response()->json($upload);
            }
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('File not uploaded.');
    }

    public function destroyImage(Request $request, Coupon $coupon)
    {
       try {
            $file_name = $request->input('file_name');

            if (File::exists($coupon->file_directory.'/'.$file_name)) {
                File::delete($coupon->file_directory.'/'.$file_name);
            }

            if (File::exists($coupon->file_directory.'/thumbnails/'.$file_name)) {
                File::delete($coupon->file_directory.'/thumbnails/'.$file_name);
            }

            $coupon->file_path = null;
            $coupon->file_directory = null;
            $coupon->file_name = null;

            if ($coupon->save()) {
                return response()->json('File deleted.');
            }
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('File not deleted.');
    }

    
}
