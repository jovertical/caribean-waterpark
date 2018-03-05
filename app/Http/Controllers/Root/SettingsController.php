<?php

namespace App\Http\Controllers\Root;

use Settings;
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

    /**
     * @param Settings $settings Injected instance of the settings service.
     */
    public function __construct(Settings $settings)
    {
        $this->reservation_settings = $settings->reservation();
    }

    public function index()
    {
        return view('root.settings.index', ['settings' => $this->reservation_settings]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'days_prior' => 'required|integer',
            'days_refundable' => 'required|integer',
            'initial_payment_rate' => 'required|integer',
            'pre_reservation_refund_rate' => 'required|integer',
            'post_reservation_refund_rate' => 'required|integer'
        ]);

        try {
            DB::table('settings')->where('name', 'days_prior')->update([
                'value' => $request->input('days_prior'),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);

            DB::table('settings')->where('name', 'initial_payment_rate')->update([
                'value' => $request->input('initial_payment_rate'),
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

                DB::table('settings')->where('name', 'pre_reservation_refund_rate')->update([
                    'value' => $request->input('pre_reservation_refund_rate'),
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()
                ]);

                DB::table('settings')->where('name', 'post_reservation_refund_rate')->update([
                    'value' => $request->input('post_reservation_refund_rate'),
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