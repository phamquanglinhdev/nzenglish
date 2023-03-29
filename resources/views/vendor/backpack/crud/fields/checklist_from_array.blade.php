@php
    $field['value'] = old($field['name']) ?? $field['value'] ?? $field['default'] ?? \App\Utils\Roles::default();
@endphp
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

<input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">

<div class="row">
    @foreach ($field['options'] as $key => $option)
        <div class="col-sm-4">
            <div class="checkbox">
                <label class="font-weight-normal">
                    <input type="checkbox" value="{{ $key }}"> {{ $option }}
                </label>
            </div>
        </div>
    @endforeach
</div>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            $(document).ready(function () {
                const arr = @json($field['value']);
                $('input[type=checkbox]').each((key, item) => {
                    if ($.inArray(item.value,arr)!==-1) {
                        $(item).attr("checked",true)
                        console.log(item)
                    }
                })
                $('input[type=checkbox]').change(function (e) {
                    let hidden_input = $('input[name={{ $field['name'] }}]');
                    let checkboxes = $('input[type=checkbox]:checked');
                    console.clear()
                    let newValue = []
                    checkboxes.each((key, option) => {
                        newValue.push(option.value)
                    })
                    hidden_input.val(JSON.stringify(newValue));
                })
            })
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
