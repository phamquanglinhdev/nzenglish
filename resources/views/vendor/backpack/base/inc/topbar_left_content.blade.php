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
                    @foreach(\App\Models\Branch::all() as $branch)
                        <option {{Cookie::get("origin")==$branch->code?"selected":""}} value="{{$branch->code}}">
                            {{$branch->name}}
                        </option>
                    @endforeach
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
<div class="mx-5 text-success font-weight-bold border p-2 rounded">
    {{\App\Models\Branch::find(Cookie::get("origin"))->name}}
</div>
