{{-- This file is used to store topbar (left) items --}}
@php
    use Illuminate\Support\Facades\Cookie
@endphp
@if(backpack_user()->role=="admin")
    <form action="{{route("origin")}}">
        <div class="input-group">
            <div class="input-group-prepend">
                <select class="form-control" name="or">
                    <option>-</option>
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
@endif
@if(backpack_user()->role!="admin")
    <div class="text-muted">{{backpack_user()->name}}</div>
@endif
<div class="mx-5 bg-success p-2 rounded">Chi nhánh hiện tại :
    @switch(Cookie::get("origin"))
        @case(1)
            <span>TP.HCM</span>
            @break
        @case(2)
            <span>BÌNH DƯƠNG</span>
            @break
        @case(3)
            <span>HÀ NỘI</span>
            @break
    @endswitch
</div>
