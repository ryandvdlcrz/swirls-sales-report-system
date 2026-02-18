<?php

namespace App\Filament\Resources\Branches\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Filament\Support\RawJs;
use Illuminate\Support\Carbon;

class BranchSalesChart extends ChartWidget
{
    public ?int $branchId = null;

    protected ?string $heading = 'Sales Trend';

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = 'month';

    protected function getData(): array
    {
        $filter = $this->filter;

        match ($filter) {
            'today' => $data = $this->getTodayData(),
            'week' => $data = $this->getWeekData(),
            'month' => $data = $this->getMonthData(),
            'year' => $data = $this->getYearData(),
            default => $data = $this->getMonthData(),
        };

        return [
            'datasets' => [
                [
                    'label' => 'Sales Amount',
                    'data' => $data['amounts'],
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Number of Transactions',
                    'data' => $data['counts'],
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array|RawJs|null
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Sales Amount (PHP)',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Transactions',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today (Hourly)',
            'week' => 'Last 7 Days',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getTodayData(): array
    {
        $data = Sale::query()
            ->where('branch_id', $this->branchId)
            ->whereDate('sale_date', Carbon::today())
            ->selectRaw('HOUR(sale_date) as hour, SUM(total_amount) as total, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $labels = [];
        $amounts = [];
        $counts = [];

        for ($i = 0; $i < 24; $i++) {
            $labels[] = Carbon::today()->setHour($i)->format('h A');
            $record = $data->firstWhere('hour', $i);
            $amounts[] = $record ? (float) $record->total : 0;
            $counts[] = $record ? $record->count : 0;
        }

        return compact('labels', 'amounts', 'counts');
    }

    protected function getWeekData(): array
    {
        $data = Sale::query()
            ->where('branch_id', $this->branchId)
            ->whereBetween('sale_date', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->selectRaw('DATE(sale_date) as date, SUM(total_amount) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $amounts = [];
        $counts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('M d');
            $amounts[] = isset($data[$date]) ? (float) $data[$date]->total : 0;
            $counts[] = isset($data[$date]) ? $data[$date]->count : 0;
        }

        return compact('labels', 'amounts', 'counts');
    }

    protected function getMonthData(): array
    {
        $data = Sale::query()
            ->where('branch_id', $this->branchId)
            ->whereYear('sale_date', Carbon::now()->year)
            ->whereMonth('sale_date', Carbon::now()->month)
            ->selectRaw('DAY(sale_date) as day, SUM(total_amount) as total, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $amounts = [];
        $counts = [];

        $daysInMonth = Carbon::now()->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = Carbon::now()->day($i)->format('M d');
            $amounts[] = isset($data[$i]) ? (float) $data[$i]->total : 0;
            $counts[] = isset($data[$i]) ? $data[$i]->count : 0;
        }

        return compact('labels', 'amounts', 'counts');
    }

    protected function getYearData(): array
    {
        $data = Sale::query()
            ->where('branch_id', $this->branchId)
            ->whereYear('sale_date', Carbon::now()->year)
            ->selectRaw('MONTH(sale_date) as month, SUM(total_amount) as total, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $amounts = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $amounts[] = isset($data[$i]) ? (float) $data[$i]->total : 0;
            $counts[] = isset($data[$i]) ? $data[$i]->count : 0;
        }

        return compact('labels', 'amounts', 'counts');
    }

    public function mount(): void
    {
        $this->branchId = request()->route('record');
    }
}
