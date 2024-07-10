<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Menu</li>
                
        <li>
            <a href="{{ url('/') }}" class="waves-effect">
                <i class="fas fa-poll"></i><span class="badge rounded-pill bg-success float-end"></span>
                <span>Dashboard</span>
            </a>
        </li>


        @if (Auth::user()->role == 'admin')
        <li>
            <a href="{{ url('admin/user') }}" class="waves-effect">
                <i class="fas fa-user-alt"></i><span class="badge rounded-pill bg-success float-end"></span>
                <span>Users</span>
            </a>
        </li>

        <li>
            <a href="{{ url('admin/kategori') }}" class="waves-effect">
                <i class="fas fa-shapes"></i><span class="badge rounded-pill bg-success float-end"></span>
                <span>Kategori</span>
            </a>
        </li>
        
        <li>
            <a href="{{ url('admin/barang') }}" class="waves-effect">
                <i class=" fas fa-boxes"></i><span class="badge rounded-pill bg-success float-end"></span>
                <span>Barang</span>
            </a>
        </li>
        @endif

        <li>
            <a href="{{ url('barang_masuk') }}" class="waves-effect">
                <i class="fas fa-truck-loading"></i><span class="badge rounded-pill bg-success float-end"></span>
                <span>Pengembalian Barang</span>
            </a>
        </li>

        <li>
            <a href="{{ url('barang_keluar') }}" class="waves-effect">
                <i class="fas fa-luggage-cart"></i><span class="badge rounded-pill bg-success float-end"></span>
                <span>Peminjaman Barang</span>
            </a>
        </li>

    </ul>
</div>