<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Best Selling Products (All Branches)
        </x-slot>

        <div x-data="{ 
                chart: null,
                initChart() {
                    const ctx = this.$refs.canvas;
                    const data = @js($bestSellers);
                    
                    this.chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(item => item.product_name),
                            datasets: [{
                                label: 'Units Sold',
                                data: data.map(item => item.total_quantity),
                                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                                borderColor: 'rgba(34, 197, 94, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                }
            }" x-init="
                if (typeof Chart === 'undefined') {
                    let script = document.createElement('script');
                    script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
                    script.onload = () => initChart();
                    document.head.appendChild(script);
                } else {
                    initChart();
                }
            " style="height: 210px;">
            <canvas x-ref="canvas"></canvas>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
