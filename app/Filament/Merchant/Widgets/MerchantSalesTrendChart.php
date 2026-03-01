<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MerchantSalesTrendChart extends ChartWidget
{
    protected ?string $heading = 'Sales Trend (Last 7 Days)';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $branchId = Auth::user()->branch_id;

        $query = Sale::query()->where('branch_id', $branchId);

        $dates = collect(range(6, 0))->map(fn($i) => Carbon::now()->subDays($i));

        $salesData = $dates->map(function ($date) use ($query) {
            return (clone $query)
                ->whereDate('sale_date', $date)
                ->sum('total_amount');
        });

        return [
            'datasets' => [
                [
                    'label'           => 'Total Sales (₱)',
                    'data'            => $salesData->values(),
                    'borderColor'     => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $dates->map(fn($d) => $d->format('M d'))->toArray(),
        ];
    }
}
