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
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-piggy-bank"></i>Quản lý tài chính</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pack') }}"><i class="nav-icon las la-coins"></i> Gói mặc định</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('extend') }}"><i class="nav-icon la la-file-invoice-dollar"></i> Hóa đơn gia hạn</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i
                    class="nav-icon la la-file-invoice-dollar"></i>
                Hóa đơn khác</a></li>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i class="nav-icon la la-file-invoice-dollar"></i> Hóa đơn chi</a></li>
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i>Quản lý lớp học</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('grade') }}"><i
                    class="nav-icon la la-boxes"></i> Lớp học</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('logs') }}"><i
                    class="nav-icon la la-history"></i> Nhật ký lớp học</a></li>
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-briefcase"></i>Quản lý văn phòng</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
                    class="nav-icon la la-user"></i> Người
                dùng</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('work') }}"><i
                    class="nav-icon la la-briefcase"></i> Nhật ký làm việc</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('document') }}"><i
                    class="nav-icon la la-file"></i>Tài liệu</a></li>
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-swatchbook"></i>Quản lý giáo
                trình</a>
            <ul class="nav-dropdown-items">
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('basket') }}"><i
                            class="nav-icon la la-list-ul"></i>
                        Danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('book') }}"><i
                            class="nav-icon la la-book"></i>Giáo trình</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-unlock-alt"></i>Quản lý phần mềm</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i
                    class='nav-icon la la-hdd-o'></i> Backups</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i
                    class='nav-icon la la-terminal'></i> Logs</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i
                    class='nav-icon las la-cog'></i> Cài đặt</a></li>
    </ul>
</li>
