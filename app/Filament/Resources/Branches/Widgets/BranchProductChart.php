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

    protected static ?string $maxHeight = '550px';

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

        $colors = [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(139, 92, 246, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(20, 184, 166, 0.8)',
            'rgba(251, 146, 60, 0.8)',
            'rgba(99, 102, 241, 0.8)',
            'rgba(234, 179, 8, 0.8)',
        ];

        $labels = $products->map(
            fn($p) => $p->product_name . ' - ' . number_format($p->total_qty) . ' sold'
        )->toArray();

        $quantities = $products->pluck('total_qty')->toArray();

        $bgColors = array_map(
            fn($i) => $colors[$i % count($colors)],
            array_keys($quantities)
        );

        return [
            'datasets' => [
                [
                    'label'           => 'Quantity Sold',
                    'data'            => $quantities,
                    'backgroundColor' => $bgColors,
                    'borderColor'     => $bgColors,
                    'borderWidth'     => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text'    => 'Quantity Sold',
                    ],
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
                'y' => [
                    'ticks' => [
                        'font' => [
                            'size' => 11,
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
