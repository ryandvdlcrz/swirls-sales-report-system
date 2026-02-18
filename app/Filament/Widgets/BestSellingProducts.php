<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BestSellingProducts extends ChartWidget
{
    protected static ?string $heading = 'Product Sales (All Branches)';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $products = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select('products.name as product_name')
            ->selectRaw('SUM(sales.qty) as total_quantity')
            ->groupBy('sales.product_id', 'products.name')
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
                ],
            ],
        ];
    }
}
