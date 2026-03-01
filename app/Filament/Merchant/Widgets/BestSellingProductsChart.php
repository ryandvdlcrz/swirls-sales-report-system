<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Product;
use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BestSellingProductsChart extends ChartWidget
{
    protected ?string $heading = 'Best Selling Products';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
            'all' => 'All Time',
        ];
    }

    protected function getData(): array
    {
        $branchId = Auth::user()->branch_id;

        // Build the sales subquery filtered by branch and date
        $salesQuery = Sale::query()
            ->where('branch_id', $branchId)
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'))
            ->groupBy('product_id');

        match ($this->filter) {
            'today' => $salesQuery->whereDate('sale_date', today()),
            'week' => $salesQuery->whereBetween('sale_date', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]),
            'month' => $salesQuery->whereBetween('sale_date', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ]),
            'year' => $salesQuery->whereYear('sale_date', now()->year),
            default => null,
        };

        // Left join all products against the filtered sales subquery
        $products = Product::query()
            ->leftJoinSub(
                $salesQuery,
                'sales_summary',
                fn($join) => $join->on('products.id', '=', 'sales_summary.product_id')
            )
            ->select(
                'products.id',
                'products.name',
                DB::raw('COALESCE(sales_summary.total_quantity, 0) as total_quantity')
            )
            ->orderByDesc('total_quantity')
            ->get();

        if ($products->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Quantity Sold',
                    'data' => $products->pluck('total_quantity')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $products->pluck('name')->toArray(),
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
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }

    public static function canView(): bool
    {
        if (request()->routeIs('filament.merchant.pages.dashboard')) {
            return false;
        }

        return true;
    }
}
