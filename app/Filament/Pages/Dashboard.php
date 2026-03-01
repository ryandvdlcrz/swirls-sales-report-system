<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\SalesOverview;
use App\Filament\Widgets\SalesTrendChart;
use App\Filament\Widgets\OverallSalesTrendChart;
use BackedEnum;

class Dashboard extends BaseDashboard
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            SalesOverview::class,
            OverallSalesTrendChart::class,
            SalesTrendChart::class,
            
        ];
    }
}
