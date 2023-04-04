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
                        <div class="mb-1">
                            <i class="las la-calendar-week"></i>
                            Tình trạng:
                            @if($student->reserve_at!=null)
                                Đang bảo lưu
                            @else
                                @if($student->old==0)
                                    @if($student->isWarning())
                                        Sắp hết hạn ( dưới 7 ngày)
                                    @elseif($student->expired())
                                    @else
                                        Đang học bình thường
                                    @endif
                                @else
                                    Học sinh cũ
                                @endif
                            @endif
                        </div>
                        <div class="mt-2">
                            <i class="las la-sticky-note"></i>
                            {{$student->note ?? "Không có ghi chú"}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($student->reserve_at)
                            <div class="mb-1">
                                <i class="las la-pause-circle"></i>
                                Ngày bắt đầu bảo lưu
                                : {{\Carbon\Carbon::create($student->reserve_at)->isoFormat("DD-MM-YYYY")}}
                            </div>
                            <div class="mb-1">
                                <i class="las la-calendar-week"></i>
                                Số ngày đang bảo lưu
                                : {{$student->reserve_day}} ngày .
                            </div>
                            <hr>
                            <div class="mb-1 mt-2">
                                <form action="{{route("reserve.reactive")}}" method="post">
                                    @csrf
                                    <input name="id" value="{{$student->id}}" hidden>
                                    <label>Ngày bắt đầu học lại</label>
                                    <input name="restart" class="form-control" type="date" required>
                                    <hr>
                                    <button type="submit" class="btn btn-success">
                                        <i class="las la-play-circle"></i>
                                        Tiếp tục học
                                    </button>
                                </form>
                            </div>
                        @else
                            @if($student->first_reg==1)
                                <div class="mb-1">
                                    <i class="la la-clock">
                                    </i>
                                    Đang chờ kích hoạt lần đầu
                                </div>
                            @else
                                <div class="mb-1">
                                    <i class="las la-calendar-week"></i>
                                    Ngày bắt đầu gói
                                    : {{\Carbon\Carbon::create($student->start)->isoFormat("DD-MM-YYYY")}}
                                </div>
                                <div class="mb-1">
                                    <i class="las la-calendar-week"></i>
                                    Ngày kết thúc gói
                                    : {{\Carbon\Carbon::create($student->end)->isoFormat("DD-MM-YYYY")}}
                                </div>
                                @if($student->expired())
                                    <div class="mb-1">
                                        <i class="las la-file-export"></i>
                                        Đã hết hạn {{$student->remaining()}} ngày
                                    </div>
                                    <a href="{{route("invoice.create",["repurchase"=>$student->id])}}"
                                       class="">
                                        <i class="las la-credit-card"></i>
                                        Gia hạn
                                    </a>
                                @else
                                    <div class="mb-1">
                                        <i class="las la-file-export"></i>
                                        Thời gian còn lại : {{$student->remaining()}} ngày
                                        @if($student->isWarning())
                                            <i class="las la-exclamation text-warning"></i>
                                        @endif
                                        <div class="mb-1">
                                            <a href="{{route("invoice.create",["repurchase"=>$student->id])}}"
                                               class="">
                                                <i class="las la-credit-card"></i>
                                                Gia hạn
                                            </a>
                                            <a href="{{route("student.deactive",["id"=>$student->id])}}"
                                               class="">
                                                <i class="las la-credit-card"></i>
                                                Bảo lưu
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
