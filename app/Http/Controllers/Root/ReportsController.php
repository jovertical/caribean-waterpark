<?php

namespace App\Http\Controllers\Root;

use Helper;
use Carbon, Notify, Excel;
use App\{Reservation};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function sales(Request $request)
    {
        $reservations = $this->filterReservation(Reservation::get(), $request->all());
        $date = $request->get('rd') ?? 'created_at';

        $data = [];

        foreach ($reservations as $reservation) {
            array_push($data, [
                'reference_number' => $reservation->reference_number,
                'status' => $reservation->status,
                'status_class' => $reservation->status_class,
                'source' => $reservation->source,
                'date'   => $reservation->$date,
                'price_taxable' => $reservation->price_taxable,
                'price_deductable' => $reservation->price_deductable,
                'gross_profit' => $reservation->price_payable,
                'net_profit' => $reservation->net_payable,
                'price_paid' => $reservation->price_paid,
                'balance' => $reservation->price_left_payable,
            ]);
        }

        $totals = [
            'price_taxable' => array_sum(array_column($data, 'price_taxable')),
            'price_deductable' => array_sum(array_column($data, 'price_deductable')),
            'gross_profit' => array_sum(array_column($data, 'gross_profit')),
            'net_profit' => array_sum(array_column($data, 'net_profit')),
            'price_paid' => array_sum(array_column($data, 'price_paid')),
            'balance' => array_sum(array_column($data, 'balance'))
        ];

        session(['root.reports.sales.data' => $data]);
        session(['root.reports.sales.totals' => $totals]);

        $data = Helper::paginate($data, 10);

        return view('root.reports.sales.index', compact(['data', 'totals']));
    }

    protected function filterReservation(Collection $reservations, array $filters)
    {
        $source = isset($filters['src']) ? strtolower($filters['src']) : null;
        $date = isset($filters['src']) ? strtolower($filters['rd']) : null;
        $from = isset($filters['from']) ? Carbon::parse($filters['from']) : null;
        $to = isset($filters['to']) ? Carbon::parse($filters['to'])->addDays(1)->subSeconds(1) : null;

        // source filter.
        if (in_array($source, ['front', 'root'])) {
            $filtered = $reservations->filter(function($reservation) use ($source) {
                return strtolower($reservation->source) == $source;
            });

            $reservations = $filtered;
        }

        // date scope filter.
        if (in_array($date, ['created_at', 'checkin_date', 'checkout_date'])) {
            if (($from != null) AND ($to != null)) {
                $filtered = $reservations->filter(function($reservation) use ($from, $to, $date) {
                    return $reservation->$date >= $from && $reservation->$date <= $to;
                });

                $reservations = $filtered;
            }

            if (($from != null) AND ($to == null)) {
                $filtered = $reservations->filter(function($reservation) use ($from, $date) {
                    return $reservation->$date >= $from;
                });

                $reservations = $filtered;
            }

            if (($from == null) AND ($to != null)) {
                $filtered = $reservations->filter(function($reservation) use ($to, $date) {
                    return $reservation->$date <= $to;
                });

                $reservations = $filtered;
            }
        }

        return $reservations;
    }

    public function exportSales(Request $request)
    {
        $file_type = strtolower($request->input('file_type'));
        $file_name = $request->input('file_name');

        try {
            $data = session()->get('root.reports.sales.data');
            $totals = session()->get('root.reports.sales.totals');

            switch ($file_type) {
                case 'pdf':
                        $export = $this->exportSalesToPDF($data, $totals, $file_name);
                    break;

                case 'excel':
                        return $this->exportSalesToExcel($data, $totals, $file_name);
                    break;

                case 'csv':
                        $export = $this->exportSalesToCsv($data, $totals, $file_name);
                    break;
            }

            if (! $export) {
                Notify::warning('We cannot export this data.', 'Whoops?!');
            }
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    protected function exportSalesToExcel(array $data, array $totals, $file_name = 'sales-report')
    {
        //
    }
}
