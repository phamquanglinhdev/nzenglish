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
    <canvas id="logStatus"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const logStatus = document.getElementById('logStatus');
    const data = {
        labels: [
            'Không tốt',
            'Tốt'
        ],
        datasets: [{
            label: 'Trạng thái buổi học',
            data: [11, 11],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
            ]
        }]
    };
    const config = {
        type: 'doughnut',
        data: data,
        options: {}
    };
    new Chart(logStatus, config)
</script>
