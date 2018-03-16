<?php

namespace App\Http\Controllers\Root;

use Helper;
use Carbon, Notify, Excel, PDF;
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
            $data['data'][] = [
                'reference_number' => $reservation->reference_number,
                'status' => $reservation->status,
                'status_class' => $reservation->status_class,
                'source' => $reservation->creator->environment_alias,
                'source_user' => $reservation->creator->full_name,
                'date'   => $reservation->$date,
                'price_taxable' => $reservation->price_taxable,
                'price_deductable' => $reservation->price_deductable,
                'gross_sale' => $reservation->price_payable,
                'net_sale' => $reservation->net_payable,
                'price_paid' => $reservation->price_paid,
                'balance' => $reservation->price_left_payable,
            ];
        }

        $data['totals'] = [
            'price_taxable' => array_sum(array_column($data, 'price_taxable')),
            'price_deductable' => array_sum(array_column($data, 'price_deductable')),
            'gross_sale' => array_sum(array_column($data, 'gross_sale')),
            'net_sale' => array_sum(array_column($data, 'net_sale')),
            'price_paid' => array_sum(array_column($data, 'price_paid')),
            'balance' => array_sum(array_column($data, 'balance'))
        ];

        session(['root.reports.sales.data' => $data]);

        $data = Helper::paginate($data, 10);

        return view('root.reports.sales.index', compact('data'));
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

            switch ($file_type) {
                case 'pdf':
                        return  $this->exportSalesAsPDF(
                                    $data, $file_name
                                );
                    break;

                case 'excel':
                        return  $this->exportSalesAsSpreadsheet(
                                    $data, $file_name
                                );
                    break;

                case 'csv':
                        return  $this->exportSalesAsSpreadsheet(
                                    $data, $file_name, 'csv'
                                );
                    break;
            }

            Notify::warning('We cannot export this data.', 'Whoops?!');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    protected function exportSalesAsPDF(array $data, $file_name = 'sales-report')
    {
        $pdf = PDF::loadView('root.reports.sales.pdf', ['data' => $data])
                    ->setPaper('a4', 'landscape')
                    ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-seriff']);

        return $pdf->download($file_name.'.pdf');
    }

    protected function exportSalesAsSpreadsheet(
        array $data,
        $file_name = 'sales-report',
        $file_type = 'xls'
    ) {
        $export = Excel::create($file_name, function($excel) use ($data) {
            $excel->sheet('Sheetname', function($sheet) use ($data)  {
                $sheet->setOrientation('landscape');

                $sheet->row(1, [
                    'Ref. #', 'Status', 'Source', 'Date', 'Tax', 'Discount',
                    'Gross Sale', 'Net Sale', 'Paid', 'Balance'
                ]);

                if (isset($data['data'])) {
                    foreach($data['data'] as $index => $metadata) {
                        $sheet->row($index + 2, [
                            $metadata['reference_number'],
                            $metadata['status'],
                            $metadata['source'],
                            Carbon::parse($metadata['date'])->format('Y-m-d'),
                            Helper::decimalFormat($metadata['price_taxable']),
                            Helper::decimalFormat($metadata['price_deductable']),
                            Helper::decimalFormat($metadata['gross_sale']),
                            Helper::decimalFormat($metadata['net_sale']),
                            Helper::decimalFormat($metadata['price_paid']),
                            Helper::decimalFormat($metadata['balance'])
                        ]);
                    }
                }

                $sheet->row(count($data) + 1, [
                    'totals',
                    '',
                    '',
                    '',
                    Helper::decimalFormat($data['totals']['price_taxable']),
                    Helper::decimalFormat($data['totals']['price_deductable']),
                    Helper::decimalFormat($data['totals']['gross_sale']),
                    Helper::decimalFormat($data['totals']['net_sale']),
                    Helper::decimalFormat($data['totals']['price_paid']),
                    Helper::decimalFormat($data['totals']['balance'])
                ]);
            });
        })->export($file_type);

        return $export;
    }
}
