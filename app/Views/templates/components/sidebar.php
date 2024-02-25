<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/dashboard">Technical Test FPP</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/dashboard"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li class="<?= $uri1 == 'index' ? 'active' : '' ?>"><a class="nav-link" href="/dashboard"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">Menu</li>

            <!-- <li class="nav-item dropdown <?= ($uri1 == 'data-transaksi') ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tasks"></i> <span>Data Pemesanan</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/dashboard/data-transaksi/belum-membayar">Belum Membayar</a></li>
                    <li><a class="nav-link" href="/dashboard/data-transaksi/sudah-membayar">Sudah Membayar</a></li>
                    <li><a class="nav-link" href="/dashboard/data-transaksi/terverifikasi">Terverifikasi</a></li>
                    <li><a class="nav-link" href="/dashboard/data-transaksi/dikirim">Dikirim</a></li>
                    <li><a class="nav-link" href="/dashboard/data-transaksi/selesai">Selesai</a></li>
                </ul>
            </li> -->


            <li class="nav-item dropdown <?= ($uri1 == 'data-transaksi') ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tasks"></i> <span>Data Produk</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/produk">Produk</a></li>
                    <li><a class="nav-link" href="/produk/tambah-produk">Tambah Produk</a></li>


                    <!-- <li><a class="nav-link" href="/dashboard/data-transaksi/dikirim">Sedang dikirim</a></li>
                    <li><a class="nav-link" href="/dashboard/data-transaksi/selesai">Selesai</a></li>-->
                </ul>
            </li>
            <!-- <li class="<?= $uri1 == 'laporan_pemesanan' ? 'active' : '' ?>"><a class="nav-link" href="/dashboard/data-pelanggan"><i class="fas fa-book"></i> 
            <span>Data Pelanggan </span></a></li> -->

            <!-- <li class="<?= $uri1 == 'laporan_pemesanan' ? 'active' : '' ?>"><a class="nav-link" href="/dashboard/kategori"><i class="fas fa-book"></i> 
            <span>Data Kategori </span></a></li> -->

            <li class="nav-item dropdown <?= ($uri1 == 'data-transaksi') ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tasks"></i> <span>Data Kategori</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/kategori">Kategori</a></li>
                    <li><a class="nav-link" href="/kategori/tambah-kategori">Tambah Kategori</a></li>

                </ul>
            </li>


            <!--<li class="menu-header">Partner</li>-->
            <!-- <li class="<?= $uri1 == 'laporan_pemesanan' ? 'active' : '' ?>"><a class="nav-link" href="/dashboard/laporan_pemesanan"><i class="fas fa-book"></i> <span>Laporan Pemesanan </span></a></li>
            <li class="<?= $uri1 == 'laporan_pemesanan' ? 'active' : '' ?>"><a class="nav-link" href="/dashboard/laporan_pemesanan"><i class="fas fa-book"></i> <span>AC dan Kipas</span></a></li> -->
        </ul>
    </aside>
</div>