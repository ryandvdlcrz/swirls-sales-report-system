<?php

namespace App\Filament\Resources\Branches\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Reactive;

class BranchProductChart extends ChartWidget
{
    #[Reactive]
    public $record;

    protected ?string $heading = 'Best Selling Products';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '500px';

    public ?string $filter = 'month';

    protected function getData(): array
    {
        if (!$this->record) {
            return ['datasets' => [], 'labels' => []];
        }

        $salesQuery = DB::table('sales')
            ->where('branch_id', $this->record->id)
            ->select('product_id', DB::raw('SUM(qty) as total_qty'));

        match ($this->filter) {
            'today' => $salesQuery->whereDate('sale_date', Carbon::today()),
            'week'  => $salesQuery->whereBetween('sale_date', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay(),
            ]),
            'month' => $salesQuery->whereYear('sale_date', Carbon::now()->year)
                ->whereMonth('sale_date', Carbon::now()->month),
            'year'  => $salesQuery->whereYear('sale_date', Carbon::now()->year),
            default => null,
        };

        $salesQuery->groupBy('product_id');

        $products = DB::table('products')
            ->leftJoinSub($salesQuery, 'sales_summary', function ($join) {
                $join->on('products.id', '=', 'sales_summary.product_id');
            })
            ->select(
                'products.name as product_name',
                DB::raw('COALESCE(sales_summary.total_qty, 0) as total_qty')
            )
            ->orderByDesc('total_qty')
            ->get();

        return [
            'datasets' => [
                [
                    'label'           => 'Quantity Sold',
                    'data'            => $products->pluck('total_qty')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor'     => 'rgb(59, 130, 246)',
                    'borderWidth'     => 1,
                ],
            ],
            'labels' => $products->pluck('product_name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                        'stepSize'  => 1,
                    ],
                    'title' => [
                        'display' => true,
                        'text'    => 'Quantity Sold',
                    ],
                ],
                'x' => [
                    'ticks' => [
                        'maxRotation' => 45,
                        'minRotation' => 45,
                        'font' => [
                            'size' => 10,
                        ],
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week'  => 'Last 7 Days',
            'month' => 'This Month',
            'year'  => 'This Year',
            'all'   => 'All Time',
        ];
    }
}
