<div class="container-fluid">
    <div class="row h-100">
        <div class="col-md-6">
            <div class="mb-2"><i class="la la-users text-primary mr-1"></i><span><b>Tên lớp</b>: {{$grade->name}}</span>
            </div>
            <div class="mb-2"><i class="la la-sort-amount-up text-primary mr-1"></i><span><b>Cấp độ</b>: {{$grade->level}}</span>
            </div>
            <div class="mb-2">
                <i class="la la-user-graduate text-primary mr-1"></i>
                <span class="font-weight-bold">Sĩ số:</span>
                <span>{{$grade->members()}}</span>
            </div>
            <div class="mb-2">
                <i class="la la-chalkboard-teacher text-primary mr-1"></i>
                <span class="font-weight-bold">GVCN:</span>
                <span>{{$grade->teacher}}</span>
            </div>
            <div class="mb-2">
                <i class="la la-tachometer-alt text-primary mr-1"></i>
                <span class="font-weight-bold">Tình trạng lớp:</span>
                <span>{{$grade->status}}</span>
            </div>
            <div class=""></div>
        </div>
        <div class="col-md-6">
            <div class="mb-2">
                <i class="la la-calendar text-primary mr-1"></i>
                <span class="font-weight-bold">Lịch học:</span>
            </div>
            @if($grade->times!=null)
                @foreach($grade->times as $time)
                    <div class="mb-1">
                        <span class="la la-clock"></span>
                        <span>{{\App\Utils\WeekDays::trans($time["day"])}} :</span>
                        <span>{{$time["start"]}}-{{$time["end"]}}</span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
