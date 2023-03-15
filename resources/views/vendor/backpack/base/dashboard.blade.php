@extends(backpack_view('blank'))
@section('content')
    <div class="append">
        <hr>
        <div class="mb-2 h5">Thống kê học sinh</div>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <a class="card border-0 text-white bg-success card-link" href="{{backpack_url("/student")}}">
                    <div class="card-body">
                        <div class="text-value">{{\App\Models\Dashboard::student()}}</div>
                        <div>Học sinh đang học.</div>
                    </div>

                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="card border-0 text-white bg-warning card-link" href="{{backpack_url("/student?end=2")}}">
                    <div class="card-body">
                        <div class="text-value">{{\App\Models\Dashboard::remaining()}}</div>
                        <div>Học sinh sắp hết hạn gói.</div>
                    </div>

                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="card border-0 text-white bg-danger card-link" href="{{backpack_url("/student?end=3")}}">
                    <div class="card-body">
                        <div class="text-value">{{\App\Models\Dashboard::expired()}}</div>
                        <div>Học sinh đã hết hạn gói.</div>
                    </div>

                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="card border-0 text-white bg-gray card-link" href="{{backpack_url("/old")}}">
                    <div class="card-body">
                        <div class="text-value">{{\App\Models\Dashboard::old()}}</div>
                        <div>Học sinh cũ.</div>

                    </div>

                </a>
            </div>
        </div>
    </div>
    <div class="append">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-2 h5">Thống kê tài chính</div>
                <div class="row">
                </div>
            </div>
        </div>
        <div class="">
            <div class="row my-3">
                <div class="col-md-3">
                    @include("components.invoice",["fin"=>\App\Models\Dashboard::getFinhance()])
                </div>
                <div class="col-md-3">
                    @include("components.payment",["fin"=>\App\Models\Dashboard::getFinhance()])
                </div>
                <div class="col-md-6">
                    @include("components.resultFinhance",["fin"=>\App\Models\Dashboard::getFinhance()])
                </div>
            </div>
        </div>
    </div>
    <div class="append">
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="mb-2 h5">Thống kê lớp học</div>
                <div class="row">
                    <div class="col-12">
                        <a class="card border-0 text-white bg-success card-link" href="{{backpack_url("/grade")}}">
                            <div class="card-body">
                                <div class="text-value">{{\App\Models\Dashboard::student()}}</div>
                                <div>Số lớp học</div>

                            </div>

                        </a>
                    </div>
                    <div class="col-12">
                        <a class="card border-0 text-white bg-warning card-link"
                           href="{{backpack_url("/logs")}}">
                            <div class="card-body">
                                <div class="text-value">{{\App\Models\Dashboard::log()}}</div>
                                <div>Nhật ký được ghi lại</div>
                            </div>

                        </a>
                    </div>
                    <div class="col-12">
                        <a class="card border-0 text-white bg-primary card-link"
                           href="{{backpack_url("#")}}">
                            <div class="card-body">
                                <div class="text-value">{{\App\Models\Dashboard::frequency()}}</div>
                                <div>Chuyên cần</div>
                            </div>

                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2 h5 text-center  p-1">Nhật ký tháng này</div>
                @include("components.logMonth")
            </div>
            <div class="col-md-3">
                <div class="mb-2 h5 text-center">Trạng thái lớp học</div>
                @include("components.logStatus")
            </div>
        </div>
    </div>

@endsection
