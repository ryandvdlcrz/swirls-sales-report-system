<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MerchantSalesTrendChart extends ChartWidget
{
    protected ?string $heading = 'Sales Trend This Month';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $branchId = Auth::user()->branch_id;
        $daysInMonth = Carbon::now()->daysInMonth;

        $sales = Sale::query()
            ->where('branch_id', $branchId)
            ->whereYear('sale_date', now()->year)
            ->whereMonth('sale_date', now()->month)
            ->selectRaw('DAY(sale_date) as day, SUM(total_amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $amounts = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = Carbon::now()->day($i)->format('M d');
            $amounts[] = isset($sales[$i]) ? (float) $sales[$i]->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Total Sales (₱)',
                    'data'            => $amounts,
                    'borderColor'     => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
