<div>
    @php
        $invoices = [];
        $total = 0;
        foreach ($fin["pack"] as $pack){
            if($pack->Invoices()->sum("value")!=0){
                $invoices[] = $pack->Invoices()->sum("value");
                $total+=$pack->Invoices()->sum("value");
            }else{
                $invoices[] = $pack->Extends()->sum("value");
                $total+=$pack->Extends()->sum("value");
            }

        }
    @endphp
    <div class="font-weight-bold my-2 text-center">Thông kê thu tháng {{\Carbon\Carbon::now()->month}}</div>
</div>
<div>
    <canvas id="invoiceBag"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const invoiceBag = document.getElementById('invoiceBag');
    const dataInvoice = {
        labels: {!!  json_encode($fin["pack"]->pluck("name")->toArray())!!},
        datasets: [{
            label: 'Tổng quan',
            data: {!!  json_encode($invoices)!!},
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
                'rgb(255,169,0)',
            ]
        }]
    };
    const configInvoice = {
        type: 'doughnut',
        data: dataInvoice,
        options: {}
    };
    new Chart(invoiceBag, configInvoice)
</script>
<div class="my-3 text-center font-weight-bold">Tổng thu :{{number_format($total)}} đ </div>
