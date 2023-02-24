<!-- text input -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')
<div class="input-group">
    @if(isset($field['prefix']))
        <div class="input-group-prepend"><span class="input-group-text">{!! $field['prefix'] !!}</span></div>
    @endif
    <input
        id="origin-{{$field['name']}}"
        type="text"
        hidden
        name="{{ $field['name'] }}"
        value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? "+84" ?? '' }}"
        @include('crud::fields.inc.attributes')
    >
    <input type="tel" id="{{$field['name']}}" class="form-control w-100" required/>
</div>
<style>
    .iti {
        width: 100% !important;
    }
</style>
@push("crud_fields_scripts")
    <script>
        $(function () {
            let code = $("#origin-{{$field['name']}}").val()
            $('#{{$field['name']}}').val(code);
            $('#{{$field['name']}}').intlTelInput({
                selectedCountryData: "VN",
                autoHideDialCode: true,
                autoPlaceholder: "ON",
                dropdownContainer: document.body,
                formatOnDisplay: true,
                hiddenInput: "full_number",
                initialCountry: "auto",
                nationalMode: true,
                placeholderNumberType: "MOBILE",
                preferredCountries: ['VN'],
                separateDialCode: true
            });
            $('#{{$field['name']}}').on('keyup', function () {
                var code = $("#{{$field['name']}}").intlTelInput("getSelectedCountryData").dialCode;
                var phoneNumber = $('#{{$field['name']}}').val();
                var name = $("#{{$field['name']}}").intlTelInput("getSelectedCountryData").name;
                let phone = "+" + code + "" + phoneNumber;
                $("#origin-{{$field['name']}}").val(phone)
            });
        });
    </script>
@endpush
</div>
