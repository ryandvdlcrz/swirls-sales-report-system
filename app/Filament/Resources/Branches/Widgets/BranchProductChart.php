<?php

namespace App\Filament\Resources\Branches\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Reactive;

class BranchProductChart extends ChartWidget
{
    #[Reactive]
    public $record;

    protected ?string $heading = 'Best Selling Products';

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = 'month';

    protected function getData(): array
    {
        if (!$this->record) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $filter = $this->filter;

        $query = Sale::query()
            ->where('branch_id', $this->record->id)
            ->with('product');

        // Apply date filter
        match ($filter) {
            'today' => $query->whereDate('sale_date', Carbon::today()),
            'week' => $query->whereBetween('sale_date', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ]),
            'month' => $query->whereYear('sale_date', Carbon::now()->year)
                ->whereMonth('sale_date', Carbon::now()->month),
            'year' => $query->whereYear('sale_date', Carbon::now()->year),
            'all' => null, // No date filter
            default => $query->whereYear('sale_date', Carbon::now()->year)
                ->whereMonth('sale_date', Carbon::now()->month),
        };

        // Get top selling products by quantity
        $productSales = $query
            ->selectRaw('product_id, SUM(qty) as total_qty, SUM(total_amount) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        $formattedLabels = [];
        $revenues = [];
        $quantities = [];
        $colors = [
            'rgba(59, 130, 246, 0.8)',   // Blue
            'rgba(16, 185, 129, 0.8)',   // Green
            'rgba(245, 158, 11, 0.8)',   // Orange
            'rgba(239, 68, 68, 0.8)',    // Red
            'rgba(139, 92, 246, 0.8)',   // Purple
            'rgba(236, 72, 153, 0.8)',   // Pink
            'rgba(20, 184, 166, 0.8)',   // Teal
            'rgba(251, 146, 60, 0.8)',   // Orange
            'rgba(99, 102, 241, 0.8)',   // Indigo
            'rgba(234, 179, 8, 0.8)',    // Yellow
        ];

        // Build labels with quantity sold
        foreach ($productSales as $sale) {
            $productName = $sale->product->name ?? 'Unknown';
            $qty = $sale->total_qty;
            $revenue = (float) $sale->total_revenue;

            // Add quantity to label
            $formattedLabels[] = $productName . ' - ' . number_format($qty) . ' sold';
            $revenues[] = $revenue;
            $quantities[] = $qty;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Quantity Sold',
                    'data' => $quantities,
                    'backgroundColor' => array_slice($colors, 0, count($quantities)),
                    'borderColor' => array_slice($colors, 0, count($quantities)),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $formattedLabels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // Horizontal bar chart
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Quantity Sold',
                    ],
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) { return 'Sold: ' + context.parsed.x + ' units'; }",
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last 7 Days',
            'month' => 'This Month',
            'year' => 'This Year',
            'all' => 'All Time',
        ];
    }
}
