{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('student') }}"><i class="nav-icon la la-user-graduate"></i>
        Học sinh</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i class="nav-icon la la-file-invoice-dollar"></i>
        Hóa đơn</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('old') }}"><i class="nav-icon la la-question"></i> Olds</a></li>