{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('student') }}"><i class="nav-icon la la-question"></i> Students</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i class="nav-icon la la-question"></i> Invoices</a></li>