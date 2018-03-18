<?php

namespace App\Http\Controllers\Root;

use Carbon, Notify;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Array of reservation settings.
     * @var array
     */
    protected $reservation_settings;

    public function __construct()
    {
        $this->reservation_settings = app('Setting')->reservation();
    }

    public function index()
    {
        return view('root.settings.index', ['settings' => $this->reservation_settings]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'days_prior' => 'required|integer',
            'minimum_reservation_length' => 'required|integer',
            'maximum_reservation_length' => 'required|integer',
            'partial_payment_rate' => 'required|integer',
            'tax_rate' => 'required|integer',
            'days_refundable' => 'required|integer',
            'refundable_rate' => 'required|integer'
        ]);

        try {
            DB::table('settings')->where('name', 'days_prior')->update([
                'value' => $request->input('days_prior'),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);

            DB::table('settings')->where('name', 'minimum_reservation_length')->update([
                'value' => $request->input('minimum_reservation_length'),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);

            DB::table('settings')->where('name', 'maximum_reservation_length')->update([
                'value' => $request->input('maximum_reservation_length'),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);         

            DB::table('settings')->where('name', 'partial_payment_rate')->update([
                'value' => $request->input('partial_payment_rate'),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);

            DB::table('settings')->where('name', 'tax_rate')->update([
                'value' => $request->input('tax_rate'),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);

            DB::table('settings')->where('name', 'allow_refund')->update([
                'value' => $request->has('allow_refund') ? 1 : 0,
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);

            if ($request->has('allow_refund')) {
                DB::table('settings')->where('name', 'days_refundable')->update([
                    'value' => $request->input('days_refundable'),
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()
                ]);

                DB::table('settings')->where('name', 'refundable_rate')->update([
                    'value' => $request->input('refundable_rate'),
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()
                ]);
            }

            Notify::success('Settings updated.', 'Success!');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }
}