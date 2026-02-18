<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SalesStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        // Daily Sales
        $dailySales = Sale::where('user_id', $userId)
            ->whereDate('sale_date', today())
            ->sum('total_amount');

        // Monthly Sales
        $monthlySales = Sale::where('user_id', $userId)
            ->whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->sum('total_amount');

        // Yearly Sales
        $yearlySales = Sale::where('user_id', $userId)
            ->whereYear('sale_date', now()->year)
            ->sum('total_amount');

        return [
            Stat::make('Daily Sales', '₱' . number_format($dailySales, 2))
                ->description("Today's total sales")
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Monthly Sales', '₱' . number_format($monthlySales, 2))
                ->description("This month's total sales")
                ->color('info')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Yearly Sales', '₱' . number_format($yearlySales, 2))
                ->description("This year's total sales")
                ->color('warning')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
