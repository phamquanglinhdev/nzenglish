@extends(backpack_view("blank"))

@section('content')
    <div class="container-fluid">
        <hr>
        <div class="h4">Báo cáo tài chính tháng {{$target}}</div>
        <a href="#" onclick="htmlTableToExcel('xlsx')" class="nav-link d-inline p-0">
            <i class="la la-download"></i>
            Tải xuống
        </a>
        <hr>
    </div>
    <div class="container-fluid">
        <form>
            <div class="input-group">
                <div class="input-group-prepend">
                    <input class="form-control rounded-0" type="number" min="1" max="12" name="month"
                           placeholder="Tháng" required>
                    <input class="form-control rounded-0" type="number" min="2019" name="year"
                           max="{{\Illuminate\Support\Carbon::now()->isoFormat("YYYY")}}" placeholder="Năm" required>
                </div>
                <button class="btn btn-success rounded-0">Truy xuất</button>
            </div>
        </form>
    </div>
    <hr>
    <div class="container-fluid">
        <table id="financeTable" class="text-center table table-bordered">
            <thead>
            <tr>
                <th>STT</th>
                <th scope="col">Ngày</th>
                <th scope="col">Thu học phí</th>
                <th scope="col">Thu khác</th>
                <th scope="col">Chi</th>
                <th scope="col">Tổng ngày</th>
            </tr>
            </thead>
            <tbody>
            @php($i=1)
            @foreach($finances as $key=>$finance)
                @if($key!="totalCol")
                    <tr>
                        <th class="text-center">{{$i}}</th>
                        <td>{{$key}}</td>
                        <td>{{number_format($finance->extend)}} đ</td>
                        <td>{{number_format($finance->invoice)}} đ</td>
                        <td>{{number_format($finance->payment)}} đ</td>
                        <td>{{number_format($finance->extend+$finance->invoice-$finance->payment)}} đ</td>
                        @php($i++)
                    </tr>
                @else
                    <tr>
                        <th>Tổng</th>
                        <th>{{$i-1}} ngày</th>
                        <th>{{number_format($finance->extend)}} đ</th>
                        <th>{{number_format($finance->invoice)}} đ</th>
                        <th>{{number_format($finance->payment)}} đ</th>
                        <th class="bg-dark text-white">{{number_format($finance->extend+$finance->invoice-$finance->payment)}}
                            đ
                        </th>
                        @php($i++)
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function htmlTableToExcel(type) {
            var data = document.getElementById('financeTable');
            var excelFile = XLSX.utils.table_to_book(data, {sheet: "{{$target}}"});
            XLSX.write(excelFile, {bookType: type, bookSST: true, type: 'base64'});
            XLSX.writeFile(excelFile, 'Báo cáo tháng {{$target}}' + "." + type, {compression: true});
        }
    </script>
@stop
@section("after_scripts")
@endsection
