<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Sale;
use App\Models\Branch;

class SalesOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Sales Overview';

    // Show on dashboard
    protected static bool $isLazy = false;

    // Enable branch filter
    public ?int $branchId = null;

    protected function getFilters(): ?array
    {
        return [
            'branch' => [
                'label' => 'Select Branch',
                'options' => Branch::pluck('name', 'id')->toArray(),
            ],
        ];
    }

    protected function getStats(): array
    {
        $query = Sale::query();

        // Filter by selected branch if any
        if ($this->filters['branch'] ?? false) {
            $query->where('branch_id', $this->filters['branch']);
        }

        $today = Carbon::today();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $dailySales = (clone $query)
            ->whereDate('sale_date', $today)
            ->sum('total_amount');

        $monthlySales = (clone $query)
            ->whereMonth('sale_date', $month)
            ->whereYear('sale_date', $year)
            ->sum('total_amount');

        $yearlySales = (clone $query)
            ->whereYear('sale_date', $year)
            ->sum('total_amount');

        return [
            Stat::make('Daily Sales', '₱' . number_format($dailySales, 2))
                ->description('Today\'s total sales')
                ->color('success'),

            Stat::make('Monthly Sales', '₱' . number_format($monthlySales, 2))
                ->description('This month\'s total sales')
                ->color('info'),

            Stat::make('Yearly Sales', '₱' . number_format($yearlySales, 2))
                ->description('This year\'s total sales')
                ->color('warning'),
        ];
    }
}
