<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BestSellingProducts extends ChartWidget
{
    protected ?string $heading = 'Product Sales (All Branches)';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '500px';

    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week'  => 'This Week',
            'month' => 'This Month',
            'year'  => 'This Year',
            'all'   => 'All Time',
        ];
    }

    protected function getData(): array
    {
        $salesQuery = DB::table('sales')
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'))
            ->groupBy('product_id');

        match ($this->filter) {
            'today' => $salesQuery->whereDate('sale_date', today()),
            'week'  => $salesQuery->whereBetween('sale_date', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]),
            'month' => $salesQuery->whereBetween('sale_date', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ]),
            'year'  => $salesQuery->whereYear('sale_date', now()->year),
            default => null,
        };

        $products = DB::table('products')
            ->leftJoinSub($salesQuery, 'sales_summary', function ($join) {
                $join->on('products.id', '=', 'sales_summary.product_id');
            })
            ->select(
                'products.name as product_name',
                DB::raw('COALESCE(sales_summary.total_quantity, 0) as total_quantity')
            )
            ->orderByDesc('total_quantity')
            ->get();

        return [
            'datasets' => [
                [
                    'label'           => 'Total Sales',
                    'data'            => $products->pluck('total_quantity')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderColor'     => 'rgba(34, 197, 94, 1)',
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
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
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
            'maintainAspectRatio' => false,
        ];
    }
}
