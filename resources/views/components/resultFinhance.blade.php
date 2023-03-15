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
<div class="card h-100 rounded">
    <div class="card-body">
        <div class="mb-3">
            <div class="h5">
                Tổng thu : {{number_format($in= $total)}} đ
            </div>
            @foreach($fin["pack"] as $pack)
                @if($pack->Invoices()->sum("value")!=0)
                <div class="text-muted">
                    {{$pack->name}} : {{number_format($pack->Invoices()->sum("value"))}} đ
                </div>
                @else
                    <div class="text-muted">
                        {{$pack->name}} : {{number_format($pack->Extends()->sum("value"))}} đ
                    </div>
                @endif
            @endforeach
        </div>
        <div class="mb-3">
            <div class="h5">
                Tổng chi : {{number_format($out=$fin["payment"]->sum("value"))}} đ
            </div>
            @foreach($fin["payment"]->get() as $payment)
                <div class="text-muted">
                    {{$payment->name}} : {{number_format($payment->value)}} đ
                </div>
            @endforeach
        </div>
        <hr>
        <div class="h5">Tổng : {{number_format($in-$out)}} đ</div>
    </div>
</div>
