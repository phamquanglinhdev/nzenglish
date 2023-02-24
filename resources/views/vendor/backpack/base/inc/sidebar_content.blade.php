{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i>Quản lý học sinh</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('student') }}"><i
                    class="nav-icon la la-user-graduate"></i>
                Học sinh đang học</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('old') }}"><i
                    class="nav-icon la la-user-clock"></i> Học sinh cũ</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i
                    class="nav-icon la la-file-invoice-dollar"></i>
                Hóa đơn</a></li>
    </ul>
</li>
