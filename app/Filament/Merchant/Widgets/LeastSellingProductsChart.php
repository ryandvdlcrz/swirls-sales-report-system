<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeastSellingProductsChart extends ChartWidget
{
    protected ?string $heading = 'Least Selling Products';

    protected static ?int $sort = 2;

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

    // FIXED: Removed the duplicate function declaration and nested structure
    protected function getData(): array
    {
        $query = Sale::query()
            ->where('user_id', Auth::id())
            ->with('product');

        // Apply date filter
        match ($this->filter) {
            'today' => $query->whereDate('sale_date', today()),
            'week' => $query->whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereMonth('sale_date', now()->month)->whereYear('sale_date', now()->year),
            'year' => $query->whereYear('sale_date', now()->year),
            'all' => $query,
            default => $query->whereMonth('sale_date', now()->month)->whereYear('sale_date', now()->year),
        };

        $leastProducts = $query
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'))
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'asc')
            ->limit(5)
            ->get();

        $labels = [];
        $data = [];

        foreach ($leastProducts as $sale) {
            if ($sale->product) {
                $labels[] = $sale->product->name;
                $data[] = (int) $sale->total_quantity;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Quantity Sold',
                    'data' => $data,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => 'rgb(239, 68, 68)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    } // FIXED: Removed the extra closing brace that was here

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
