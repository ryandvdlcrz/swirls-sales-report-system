<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class BestSellingProducts extends Widget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1; // Changed from 'full' to 1

    public function mount(): void
    {
        $this->view = 'filament.widgets.best-selling-products-chart';
    }

    protected function getViewData(): array
    {
        return [
            'bestSellers' => $this->getBestSellers(),
        ];
    }

    public function getBestSellers()
    {
        return DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select('products.name as product_name')
            ->selectRaw('SUM(sales.qty) as total_quantity')
            ->groupBy('sales.product_id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
    }
}
