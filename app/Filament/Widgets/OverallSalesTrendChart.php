<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class OverallSalesTrendChart extends ChartWidget
{
    protected ?string $heading = 'Overall Sales Trend';

    protected int | string | array $columnSpan = 1;

    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today (Hourly)',
            'week'  => 'Last 7 Days',
            'month' => 'This Month',
            'year'  => 'This Year',
            'all'   => 'All Time',
        ];
    }

    protected function getData(): array
    {
        match ($this->filter) {
            'today' => $data = $this->getTodayData(),
            'week'  => $data = $this->getWeekData(),
            'month' => $data = $this->getMonthData(),
            'year'  => $data = $this->getYearData(),
            'all'   => $data = $this->getAllTimeData(),
            default => $data = $this->getWeekData(),
        };

        return [
            'datasets' => [
                [
                    'label'           => 'Total Sales (₱)',
                    'data'            => $data['amounts'],
                    'borderColor'     => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getTodayData(): array
    {
        $sales = Sale::query()
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

    protected function getWeekData(): array
    {
        $dates = collect(range(6, 0))->map(fn($i) => Carbon::now()->subDays($i));

        $amounts = $dates->map(function ($date) {
            return (float) Sale::query()
                ->whereDate('sale_date', $date)
                ->sum('total_amount');
        })->toArray();

        $labels = $dates->map(fn($d) => $d->format('M d'))->toArray();

        return compact('labels', 'amounts');
    }

    protected function getMonthData(): array
    {
        $sales = Sale::query()
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

    protected function getYearData(): array
    {
        $sales = Sale::query()
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

    protected function getAllTimeData(): array
    {
        $sales = Sale::query()
            ->selectRaw('DATE_FORMAT(sale_date, "%Y-%m") as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $firstSale = Sale::query()->orderBy('sale_date')->first();

        if (!$firstSale) {
            return ['labels' => [], 'amounts' => []];
        }

        $start = Carbon::parse($firstSale->sale_date)->startOfMonth();
        $end = Carbon::now()->startOfMonth();

        $labels = [];
        $amounts = [];

        while ($start->lte($end)) {
            $key = $start->format('Y-m');
            $labels[] = $start->format('M Y');
            $amounts[] = isset($sales[$key]) ? (float) $sales[$key]->total : 0;
            $start->addMonth();
        }

        return compact('labels', 'amounts');
    }

    protected function getType(): string
    {
        return 'line';
    }
}
