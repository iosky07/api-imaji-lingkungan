<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="" alt="">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Kelompok Sosial</li>
            <li class="">
                <a class="nav-link" href="{{route('admin.user',1)}}">
                    <i class="fas fa-fire"></i>
                    <span>Mawar Putih</span>
                </a>
            </li>
            <li class="">
                <a class="nav-link" href="{{route('admin.user',2)}}">
                    <i class="fas fa-fire"></i>
                    <span>Sumber Rejeki</span>
                </a>
            </li>
            <li class="">
                <a class="nav-link" href="{{route('admin.user',3)}}">
                    <i class="fas fa-fire"></i>
                    <span>Barokah Jaya</span>
                </a>
            </li>
            <li class="menu-header">Penjemputan</li>
            <li class="">
                <a class="nav-link" href="{{route('admin.pickup')}}">
                    <i class="fas fa-fire"></i>
                    <span>Riwayat Penjemputan</span>
                </a>
            </li>

        </ul>
    </aside>
</div>
