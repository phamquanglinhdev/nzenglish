<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <img src="{{$student->avatar}}" class="w-100 rounded">
        </div>
        <div class="col-md-9 p-2 bg-white rounded">
            <div class="">
                <div class="h3 text-primary">{{$student->name}}</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <i class="las la-birthday-cake"></i>
                            {{\Carbon\Carbon::create($student->birthday)->isoFormat("DD-MM-YYYY")}}
                        </div>
                        <div class="mb-1">
                            <i class="las la-mobile"></i>
                            {{$student->phone}}
                        </div>
                        <div class="mb-1">
                            <i class="las la-school"></i>
                            Lớp: {{$student->grade}}
                        </div>
                        <div class="mb-1">
                            <i class="las la-calendar-week"></i>
                            Ngày bắt đầu học : {{\Carbon\Carbon::create($student->first)->isoFormat("DD-MM-YYYY")}}
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="mb-1">
                            <i class="las la-calendar-week"></i>
                            Ngày bắt đầu gói : {{\Carbon\Carbon::create($student->start)->isoFormat("DD-MM-YYYY")}}
                        </div>
                        <div class="mb-1">
                            <i class="las la-calendar-week"></i>
                            Ngày kết thúc gói : {{\Carbon\Carbon::create($student->end)->isoFormat("DD-MM-YYYY")}}
                        </div>
                        @if($student->expired())
                            <div class="mb-1">
                                <i class="las la-file-export"></i>
                                Đã hết hạn {{$student->remaining()}} ngày
                            </div>
                        @else
                            <div class="mb-1">
                                <i class="las la-file-export"></i>
                                Thời gian còn lại : {{$student->remaining()}} ngày
                                @if($student->isWarning())
                                    <i class="las la-exclamation text-warning"></i>
                                @endif
                            </div>
                        @endif
                        <div class="mb-1">
                            <a href="{{route("invoice.create",["repurchase"=>$student->id])}}"
                               class="">
                                <i class="las la-credit-card"></i>
                                Gia hạn
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <i class="las la-sticky-note"></i>
                    {{$student->note ?? "Không có ghi chú"}}
                </div>
            </div>
        </div>
    </div>
</div>
