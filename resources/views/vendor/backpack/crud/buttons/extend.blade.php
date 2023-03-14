@if(!$entry->confirm)
    <a href="javascript:void(0)" onclick="extendEntry(this)" data-route="{{ route("extend") }}"
       class="btn btn-sm btn-link" data-button-type="delete"><i
            class="la la-check-circle"></i> Gia hạn</a>
@else
    <a class="btn btn-sm btn-link text-success">Đã gia hạn</a>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@loadOnce('delete_button_script')
@push('after_scripts') @if (request()->ajax())
    @endpush
@endif
<script>

    if (typeof extendEntry != 'function') {
        $("[data-button-type=delete]").unbind('click');

        function extendEntry(button) {
            var route = $(button).attr('data-route');
            var id = {{$entry->id}}
            swal({
                title: "Gia hạn hóa đơn",
                text: "Đồng ý gia hạn",
                icon: "success",
                buttons: ["{!! trans('backpack::crud.cancel') !!}", "Đồng ý"],
            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: {id: id},
                        success: function (result) {
                            new Noty({
                                type: "success",
                                text: "Gia hạn thành công"
                            }).show();

                            // Hide the modal, if any
                            $('.modal').modal('hide');
                            window.location.reload()
                        },
                        error: function (result) {
                            // Show an alert with the result
                            swal({
                                title: "{!! trans('backpack::crud.delete_confirmation_not_title') !!}",
                                text: "{!! trans('backpack::crud.delete_confirmation_not_message') !!}",
                                icon: "error",
                                timer: 4000,
                                buttons: false,
                            });
                        }
                    });
                }
            });

        }
    }

    // make it so that the function above is run after each DataTable draw event
    // crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
</script>
@if (!request()->ajax())
    @endpush
@endif
@endLoadOnce
