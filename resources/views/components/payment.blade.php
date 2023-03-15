<div>

    <div class="font-weight-bold my-2 text-center">Thông kê chi tháng {{\Carbon\Carbon::now()->month}}</div>
</div>
<div>
    <canvas id="paymentBag"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const paymentBag = document.getElementById('paymentBag');
    const datapayment = {
        labels: {!!  json_encode($fin["payment"]->pluck("name")->toArray())!!},
        datasets: [{
            label: 'Tổng quan',
            data: {!!  json_encode($fin["payment"]->pluck("value")->toArray())!!},
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
                'rgb(255,169,0)',
                'rgb(36,0,255)',
            ]
        }]
    };
    const configPayment = {
        type: 'doughnut',
        data: datapayment,
        options: {}
    };
    new Chart(paymentBag, configPayment)
</script>
<div class="my-3 text-center font-weight-bold">Tổng chi :{{number_format($fin["payment"]->sum("value"))}} đ </div>
