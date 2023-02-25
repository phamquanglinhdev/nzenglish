{{-- This file is used to store topbar (left) items --}}
@php
    use Illuminate\Support\Facades\Cookie
@endphp
<form action="{{route("origin")}}">
    <div class="input-group">
        <div class="input-group-prepend">
            <select class="form-control" name="or">
                <option {{Cookie::get("origin")==1?"selected":""}} value="1">CN TP.Hồ Chí
                    Minh
                </option>
                <option {{Cookie::get("origin")==2?"selected":""}} value="2">CN Bình Dương
                </option>
                <option {{Cookie::get("origin")==3?"selected":""}} value="3">CN Hà Nội</option>
            </select>
        </div>
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Chuyển chi nhánh</button>
        </div>
    </div>

</form>
