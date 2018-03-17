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
        $sales = $this->getSalesData($this->filters($request));
        $data = Helper::paginate($sales['data']);
        $totals = $sales['totals'];

        return view('root.reports.sales.index', compact(['data', 'totals']));
    }

    protected function getSalesData(array $filters)
    {
        $reservations = $this->filterReservation(
                            Reservation::get(),
                            $filters
                        );

        $data = [];
        $totals = [];

        if (count($reservations)) {
            foreach ($reservations as $reservation) {
                $data[] = [
                    'reference_number' => $reservation->reference_number,
                    'status' => $reservation->status,
                    'status_class' => $reservation->status_class,
                    'source' => $reservation->creator->environment_alias,
                    'source_user' => $reservation->creator->full_name,
                    'date'   => $reservation->created_at,
                    'price_taxable' => $reservation->price_taxable,
                    'price_deductable' => $reservation->price_deductable,
                    'gross_sale' => $reservation->price_payable,
                    'net_sale' => $reservation->net_payable,
                    'price_paid' => $reservation->price_paid,
                    'balance' => $reservation->price_left_payable,
                ];
            }

            $totals = [
                'price_taxable' => array_sum(array_column($data, 'price_taxable')),
                'price_deductable' => array_sum(array_column($data, 'price_deductable')),
                'gross_sale' => array_sum(array_column($data, 'gross_sale')),
                'net_sale' => array_sum(array_column($data, 'net_sale')),
                'price_paid' => array_sum(array_column($data, 'price_paid')),
                'balance' => array_sum(array_column($data, 'balance'))
            ];
        }

        return compact(['data', 'totals']);
    }

    public function exportSales(Request $request)
    {
        $file_type = strtolower($request->input('file_type'));
        $file_name = $request->input('file_name');

        try {
            $sales = $this->getSalesData($this->filters($request));

            switch ($file_type) {
                case 'pdf':
                        return  $this->exportSalesAsPDF(
                                    $sales['data'], $sales['totals'], $file_name
                                );
                    break;

                case 'excel':
                        return  $this->exportSalesAsSpreadsheet(
                                    $sales['data'], $sales['totals'], $file_name
                                );
                    break;

                case 'csv':
                        return  $this->exportSalesAsSpreadsheet(
                                    $sales['data'], $sales['totals'], $file_name, 'csv'
                                );
                    break;
            }

            Notify::warning('We cannot export this data.', 'Whoops?!');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    protected function exportSalesAsPDF(
        array $data,
        array $totals,
        $file_name = 'sales-report'
    ) {
        $pdf = PDF::loadView('root.reports.sales.pdf', ['data' => $data, 'totals' => $totals])
                    ->setPaper('a4', 'landscape')
                    ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-seriff']);

        return $pdf->download($file_name.'.pdf');
    }

    protected function exportSalesAsSpreadsheet(
        array $data,
        array $totals,
        $file_name = 'sales-report',
        $file_type = 'xls'
    ) {
        $export = Excel::create($file_name, function($excel) use ($data, $totals) {
            $excel->sheet('Sheetname', function($sheet) use ($data, $totals)  {
                $sheet->setOrientation('landscape');

                $sheet->row(1, [
                    'Ref. #', 'Status', 'Source', 'Date', 'Tax', 'Discount',
                    'Gross Sale', 'Net Sale', 'Paid', 'Balance'
                ]);

                foreach($data as $index => $metadata) {
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

                $sheet->row(count($data) + 1, [
                    'totals',
                    '',
                    '',
                    '',
                    Helper::decimalFormat($totals['price_taxable']),
                    Helper::decimalFormat($totals['price_deductable']),
                    Helper::decimalFormat($totals['gross_sale']),
                    Helper::decimalFormat($totals['net_sale']),
                    Helper::decimalFormat($totals['price_paid']),
                    Helper::decimalFormat($totals['balance'])
                ]);
            });
        })->export($file_type);

        return $export;
    }

    public function allocations(Request $request)
    {
        $allocations = $this->getAllocationsData($this->filters($request));
        $data = Helper::paginate($allocations['data']);
        $totals = $allocations['totals'];

        return view('root.reports.allocations.index', compact(['data', 'totals']));
    }

    protected function getAllocationsData(array $filters)
    {
        $reservations = $this->filterReservation(
                            Reservation::whereIn('status', ['paid', 'reserved'])->get(),
                            $filters
                        );

        $days = Carbon::parse($filters['from'])->diffInDays(
                    Carbon::parse($filters['to'])
                ) + 1;

        $data = [];
        $totals = [];

        if (count($reservations)) {
            foreach ($reservations as $reservation) {
                foreach ($reservation->items as $index => $reservation_item) {
                    $item = $reservation_item->item;
                    $quantity = $reservation_item->item->quantity * $days;
                    $occupied = (int) $reservation_item->quantity;
                    $unoccupied = $quantity - $reservation_item->quantity;
                    $inactive = ! $item->active ? $item->quantity * $days : 0;
                    $average_occupancy = ($occupied / max($quantity, 1)) * 100;
                    $daily_sales = $reservation_item->net_payable / max($days, 1);
                    $net_sales = $reservation_item->net_payable;

                    if (isset($data[$index]['item'])) {
                        if (in_array($item->id, array_column(array_column($data, 'item'), 'id'))) {
                            /**
                             * Index of same item in the data array.
                             * @var integer
                             */
                            $repeated_index = array_search(
                                $item->id, array_column(array_column($data, 'item'), 'id')
                            );

                            $data[$repeated_index]['occupied'] += $occupied;
                            $data[$repeated_index]['unoccupied'] -= $occupied;
                            $data[$repeated_index]['average_occupancy'] =
                                (($occupied+=$occupied) / max($quantity, 1)) * 100;
                            $data[$repeated_index]['daily_sales'] += $daily_sales;
                            $data[$repeated_index]['net_sales'] += $net_sales;

                            break;
                        }
                    }

                    $data[] = [
                        'item' => $item,
                        'quantity' => $quantity,
                        'occupied' => $occupied,
                        'unoccupied' => $unoccupied,
                        'inactive' => $inactive,
                        'average_occupancy' => $average_occupancy,
                        'daily_sales' => $daily_sales,
                        'net_sales' => $net_sales
                    ];
                }
            }

            $totals= [
                'quantity' => array_sum(array_column($data, 'quantity')),
                'occupied' => array_sum(array_column($data, 'occupied')),
                'unoccupied' => array_sum(array_column($data, 'unoccupied')),
                'inactive' => array_sum(array_column($data, 'inactive')),
                'average_occupancy' =>  array_sum(array_column($data, 'average_occupancy')) / count($data),
                'daily_sales' => array_sum(array_column($data, 'daily_sales')),
                'net_sales' => array_sum(array_column($data, 'net_sales'))
            ];
        }

        return compact(['data', 'totals']);
    }

    public function exportAllocations(Request $request)
    {
        $file_type = strtolower($request->input('file_type'));
        $file_name = $request->input('file_name');

        try {
            $allocations = $this->getAllocationsData($this->filters($request));

            switch ($file_type) {
                case 'pdf':
                        return  $this->exportAllocationsAsPDF(
                                    $allocations['data'], $allocations['totals'], $file_name
                                );
                    break;

                case 'excel':
                        return  $this->exportAllocationsAsSpreadsheet(
                                    $allocations['data'], $allocations['totals'], $file_name
                                );
                    break;

                case 'csv':
                        return  $this->exportAllocationsAsSpreadsheet(
                                    $allocations['data'], $allocations['totals'], $file_name, 'csv'
                                );
                    break;
            }

            Notify::warning('We cannot export this data.', 'Whoops?!');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    protected function exportAllocationsAsPDF(
        array $data,
        array $totals,
        $file_name = 'allocations-report'
    ) {
        $pdf = PDF::loadView('root.reports.allocations.pdf', ['data' => $data, 'totals' => $totals])
                    ->setPaper('a4', 'landscape')
                    ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-seriff']);

        return $pdf->download($file_name.'.pdf');
    }

    protected function exportAllocationsAsSpreadsheet(
        array $data,
        array $totals,
        $file_name = 'allocations-report',
        $file_type = 'xls'
    ) {
        $export = Excel::create($file_name, function($excel) use ($data, $totals) {
            $excel->sheet('Sheetname', function($sheet) use ($data, $totals)  {
                $sheet->setOrientation('landscape');

                $sheet->row(1, [
                    'Item', 'Quantity', 'Occupied', 'Unoccupied', 'Inactive',
                    'Avg. Occupancy', 'Daily Sales', 'Net Sales'
                ]);

                foreach($data as $index => $metadata) {
                    $sheet->row($index + 2, [
                        $metadata['item']->name,
                        $metadata['quantity'],
                        $metadata['occupied'],
                        $metadata['unoccupied'],
                        $metadata['inactive'],
                        Helper::decimalFormat($metadata['average_occupancy']),
                        Helper::decimalFormat($metadata['daily_sales']),
                        Helper::decimalFormat($metadata['net_sales'])
                    ]);
                }

                $sheet->row(count($data) + 1, [
                    'totals',
                    $totals['quantity'],
                    $totals['occupied'],
                    $totals['unoccupied'],
                    $totals['inactive'],
                    Helper::decimalFormat($totals['average_occupancy']),
                    Helper::decimalFormat($totals['daily_sales']),
                    Helper::decimalFormat($totals['net_sales'])
                ]);
            });
        })->export($file_type);

        return $export;
    }

    protected function filterReservation(Collection $reservations, array $filters)
    {
        $source = $filters['source'];
        $date = $filters['date'] ?? 'created_at';
        $from = $filters['from'];
        $to = $filters['to'];

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
                $from = Carbon::parse($from);
                $to = Carbon::parse($to)->addSeconds(86399);
                $filtered = $reservations->filter(function($reservation) use ($from, $to, $date) {
                    return $reservation->$date >= $from && $reservation->$date <= $to;
                });

                $reservations = $filtered;
            }

            if (($from != null) AND ($to == null)) {
                $from = Carbon::parse($from);
                $filtered = $reservations->filter(function($reservation) use ($from, $date) {
                    return $reservation->$date >= $from;
                });

                $reservations = $filtered;
            }

            if (($from == null) AND ($to != null)) {
                $to = Carbon::parse($to)->addSeconds(86399);
                $filtered = $reservations->filter(function($reservation) use ($to, $date) {
                    return $reservation->$date <= $to;
                });

                $reservations = $filtered;
            }
        }

        return $reservations;
    }

    protected function filters(Request $request)
    {
        return [
            'source' => $request->get('src'),
            'date' => $request->get('dt'),
            'from' => $request->get('from'),
            'to' => $request->get('to'),
        ];
    }
}