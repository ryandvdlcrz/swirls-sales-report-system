<?php

namespace App\Filament\Merchant\Resources\Sales\Pages;

use App\Filament\Merchant\Resources\Sales\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Merchant\Widgets\LeastSellingProductsChart;
use App\Filament\Merchant\Widgets\BestSellingProductsChart;
class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BestSellingProductsChart::class,
            LeastSellingProductsChart::class,
        ];
    }
}
