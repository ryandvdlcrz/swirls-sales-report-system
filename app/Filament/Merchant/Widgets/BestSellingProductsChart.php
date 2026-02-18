<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BestSellingProductsChart extends ChartWidget
{
    protected ?string $heading = 'Best Selling Product';

    protected static ?int $sort = 1;

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
        $query = Sale::query()
            ->where('branch_id', Auth::user()->branch_id)
            ->with('product');

        // Apply date filter
        match ($this->filter) {
            'today' => $query->whereDate('sale_date', today()),
            'week' => $query->whereBetween('sale_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]),
            'month' => $query->whereBetween('sale_date', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]),
            'year' => $query->whereYear('sale_date', now()->year),
            default => null,
        };

        $topProduct = $query
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->first(); // 🔥 only top 1

        if (! $topProduct) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Quantity Sold',
                    'data' => [$topProduct->total_quantity],
                    'backgroundColor' => ['rgba(59, 130, 246, 0.5)'],
                    'borderColor' => ['rgb(59, 130, 246)'],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [
                $topProduct->product->name ?? 'Unknown',
            ],
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
