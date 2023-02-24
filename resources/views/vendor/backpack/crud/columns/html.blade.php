{{-- regular object attribute --}}
@php
    $value = data_get($entry, $column['name']);
    $value = is_array($value) ? json_encode($value) : $value;

    $column['escaped'] = $column['escaped'] ?? true;
    $column['limit'] = $column['limit'] ?? 40;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    <div class="w-100">
        <a type="button" class="text-primary" data-toggle="modal" data-target="#{{$column['name']}}">
        Xem thông tin
        </a>
    </div>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
@section("after_scripts")
    <div class="modal fade bd-example-modal-lg" id="{{$column['name']}}" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-lg-3 p-1">
                <div class="h2">Thông tin lớp học</div>
                <hr>
                {!! $value !!}
            </div>
        </div>
    </div>
@endsection
