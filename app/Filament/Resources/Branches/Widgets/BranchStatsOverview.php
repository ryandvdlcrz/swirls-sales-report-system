<?php

namespace App\Filament\Resources\Branches\Widgets;

use App\Models\Branch;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Reactive;

class BranchStatsOverview extends BaseWidget
{
    #[Reactive]
    public $record;

    protected function getStats(): array
    {
        if (!$this->record) {
            return [];
        }

        $branch = $this->record;

        if (!$branch) {
            return [];
        }

        // Daily Statistics
        $dailySales = $branch->sales()
            ->whereDate('sale_date', Carbon::today())
            ->sum('total_amount');

        $dailyCount = $branch->sales()
            ->whereDate('sale_date', Carbon::today())
            ->count();

        // Monthly Statistics
        $monthlySales = $branch->sales()
            ->whereYear('sale_date', Carbon::now()->year)
            ->whereMonth('sale_date', Carbon::now()->month)
            ->sum('total_amount');

        $monthlyCount = $branch->sales()
            ->whereYear('sale_date', Carbon::now()->year)
            ->whereMonth('sale_date', Carbon::now()->month)
            ->count();

        // Yearly Statistics
        $yearlySales = $branch->sales()
            ->whereYear('sale_date', Carbon::now()->year)
            ->sum('total_amount');

        $yearlyCount = $branch->sales()
            ->whereYear('sale_date', Carbon::now()->year)
            ->count();

        // Previous day for comparison
        $yesterdaySales = $branch->sales()
            ->whereDate('sale_date', Carbon::yesterday())
            ->sum('total_amount');

        $dailyChange = $yesterdaySales > 0
            ? (($dailySales - $yesterdaySales) / $yesterdaySales) * 100
            : 0;

        // Previous month for comparison
        $lastMonthSales = $branch->sales()
            ->whereYear('sale_date', Carbon::now()->subMonth()->year)
            ->whereMonth('sale_date', Carbon::now()->subMonth()->month)
            ->sum('total_amount');

        $monthlyChange = $lastMonthSales > 0
            ? (($monthlySales - $lastMonthSales) / $lastMonthSales) * 100
            : 0;

        return [
            Stat::make('Today\'s Sales', '₱' . number_format($dailySales, 2))
                ->description($dailyCount . ' transactions')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('This Month\'s Sales', '₱' . number_format($monthlySales, 2))
                ->description($monthlyCount . ' transactions')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3, 6, 7, 8, 9])
                ->color('info'),

            Stat::make('This Year\'s Sales', '₱' . number_format($yearlySales, 2))
                ->description($yearlyCount . ' transactions')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart([3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])
                ->color('warning'),
        ];
    }
}
