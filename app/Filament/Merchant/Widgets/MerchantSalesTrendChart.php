<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MerchantSalesTrendChart extends ChartWidget
{
    protected ?string $heading = 'Sales Trend';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today (Hourly)',
            'week'  => 'Last 7 Days',
            'month' => 'This Month',
            'year'  => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $branchId = Auth::user()->branch_id;

        match ($this->filter) {
            'today' => $data = $this->getTodayData($branchId),
            'week'  => $data = $this->getWeekData($branchId),
            'month' => $data = $this->getMonthData($branchId),
            'year'  => $data = $this->getYearData($branchId),
            default => $data = $this->getMonthData($branchId),
        };

        return [
            'datasets' => [
                [
                    'label'           => 'Total Sales (₱)',
                    'data'            => $data['amounts'],
                    'borderColor'     => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getTodayData(int $branchId): array
    {
        $sales = Sale::query()
            ->where('branch_id', $branchId)
            ->whereDate('sale_date', Carbon::today())
            ->selectRaw('HOUR(sale_date) as hour, SUM(total_amount) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $labels = [];
        $amounts = [];

        for ($i = 0; $i < 24; $i++) {
            $labels[] = Carbon::today()->setHour($i)->format('h A');
            $amounts[] = isset($sales[$i]) ? (float) $sales[$i]->total : 0;
        }

        return compact('labels', 'amounts');
    }

    protected function getWeekData(int $branchId): array
    {
        $sales = Sale::query()
            ->where('branch_id', $branchId)
            ->whereBetween('sale_date', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay(),
            ])
            ->selectRaw('DATE(sale_date) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $amounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('M d');
            $amounts[] = isset($sales[$date]) ? (float) $sales[$date]->total : 0;
        }

        return compact('labels', 'amounts');
    }

    protected function getMonthData(int $branchId): array
    {
        $sales = Sale::query()
            ->where('branch_id', $branchId)
            ->whereYear('sale_date', Carbon::now()->year)
            ->whereMonth('sale_date', Carbon::now()->month)
            ->selectRaw('DAY(sale_date) as day, SUM(total_amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $amounts = [];
        $daysInMonth = Carbon::now()->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = Carbon::now()->day($i)->format('M d');
            $amounts[] = isset($sales[$i]) ? (float) $sales[$i]->total : 0;
        }

        return compact('labels', 'amounts');
    }

    protected function getYearData(int $branchId): array
    {
        $sales = Sale::query()
            ->where('branch_id', $branchId)
            ->whereYear('sale_date', Carbon::now()->year)
            ->selectRaw('MONTH(sale_date) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $amounts = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $amounts[] = isset($sales[$i]) ? (float) $sales[$i]->total : 0;
        }

        return compact('labels', 'amounts');
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
