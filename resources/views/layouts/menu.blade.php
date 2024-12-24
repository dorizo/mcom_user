<li>
    <a class="nav-link" href="#"
        ><i class="far fa-square"></i> <span>Dashboard</span></a
    >
</li>

<li class="menu-header">Korpri</li>
<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"
        ><i class="fas fa-th-large"></i> <span>Berita</span></a
    >
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="#">Liat</a>
        </li>
        <li>
            <a class="nav-link" href="#">Buat</a>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"
        ><i class="fas fa-th-large"></i> <span>Menu</span></a
    >
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="{{ route('menu.index') }}">Liat</a></li>
        <li><a class="nav-link" href="{{ route('menu.create') }}">Buat</a></li>
    </ul>
</li>
<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a
        href="https://getKorpri.com/docs"
        class="btn btn-primary btn-lg btn-block btn-icon-split"
    >
        <i class="fas fa-rocket"></i> Documentation
    </a>
</div>
