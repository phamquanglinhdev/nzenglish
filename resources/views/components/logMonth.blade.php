@php
    $day=[];
    $log=[];
    $start = \Carbon\Carbon::parse(now())->startOfMonth();
    $end = \Carbon\Carbon::parse(now())->endOfMonth();
    $period = \Carbon\CarbonPeriod::create($start,$end);
    foreach ($period as $date){
        $day[] = $date->isoFormat("DD");
        $log[]=\App\Models\Log::where("date","=",\Illuminate\Support\Carbon::parse($date))->count();
    }
    $days = implode(",",$day);
    $logs = implode(",",$log);
//    dd(implode(",",$day));
@endphp
<div>
    <canvas id="logMonth"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const logMonth = document.getElementById('logMonth');

    new Chart(logMonth, {
        type: 'line',
        data: {
            labels: [{{$days}}],
            datasets: [{
                label: 'Số buổi học diễn ra trong tháng',
                data: [{{$logs}}],
                borderWidth: 1
            }]
        },
        options: {
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Line Chart'
                    }
                }
            },
        }
    });
</script>
