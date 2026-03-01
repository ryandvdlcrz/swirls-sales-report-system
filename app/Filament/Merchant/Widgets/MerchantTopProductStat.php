<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MerchantTopProductStat extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $branchId = Auth::user()->branch_id;

        // Best selling product this month
        $topThisMonth = Sale::query()
            ->where('branch_id', $branchId)
            ->whereBetween('sale_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        // Best selling product this year
        $topThisYear = Sale::query()
            ->where('branch_id', $branchId)
            ->whereYear('sale_date', now()->year)
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        // Best selling product all time
        $topAllTime = Sale::query()
            ->where('branch_id', $branchId)
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        return [
            Stat::make(
                'Best Product This Month',
                $topThisMonth?->product?->name ?? 'No sales yet'
            )
                ->description($topThisMonth ? $topThisMonth->total_qty . ' units sold' : 'No data')
                ->color('success'),

            Stat::make(
                'Best Product This Year',
                $topThisYear?->product?->name ?? 'No sales yet'
            )
                ->description($topThisYear ? $topThisYear->total_qty . ' units sold' : 'No data')
                ->color('info'),

            Stat::make(
                'Best Product All Time',
                $topAllTime?->product?->name ?? 'No sales yet'
            )
                ->description($topAllTime ? $topAllTime->total_qty . ' units sold' : 'No data')
                ->color('warning'),
        ];
    }
}
