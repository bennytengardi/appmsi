<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MSI</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&display=swap" rel="stylesheet"> 
    <!--<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">-->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
    <link href="<?= base_url() ?>/assets/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/sweetalert2/animate.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <style>
        .swal2-popup {
            font-size: 0.7rem !important;
        }
    </style>
    <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition layout-top-nav" style="font-family: 'Domine', serif;font-size: 12px;"> 
<!--<body class="hold-transition layout-top-nav" style="font-family: 'Noto Serif', serif;font-size: 14px;">-->
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-dark">
            <!-- <nav class="main-header navbar navbar-expand-md navbar-light navbar-primary"> -->
            <a href="<?= base_url() ?>" class="navbar-brand mx-5">
                <img src="<?= base_url() ?>/assets/img/logo msi.png" alt="AdminLTE Logo" class="brand-image elevation-3 " style="width: 90px;height: 40px;margin-top: 0px">

                <?php if (session()->get('username') == "") { ?>
                    <span class="brand-text font-weight-bold text-warning text-lg">PT. MULTI SCREEN INDONESIA</span>
                <?php } else { ?>
                    <span class="brand-text font-weight-bold text-warning" style="font-size: 16px"><?= session()->get('nama_company') ?> </span>
                <?php } ?>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <?php if (session()->get('username') <> "") {  ?>

                <!--LEVEL-1 = ADMINISTRATOR -->
                <?php if (session()->get('level') == "1") { ?>
                    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="<?= base_url('admin') ?>" class="nav-link text-white">Dashboard</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">Daftar</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('Satuan') ?>" class="dropdown-item">Satuan</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Merk') ?>" class="dropdown-item">Merk</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Supplier') ?>" class="dropdown-item">Supplier</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Customer') ?>" class="dropdown-item">Customer</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Salesman') ?>" class="dropdown-item">Salesman</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu5" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">Aktifitas</a>
                                <ul aria-labelledby="dropdownSubMenu5" class="dropdown-menu border-0 text-sm shadow">
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Penjualan</a>
                                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('SalesOrd') ?>" class="dropdown-item">Sales Order</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('SuratJln') ?>" class="dropdown-item">Surat Jalan</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('SalesInv') ?>" class="dropdown-item">Faktur Penjualan</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('SalesRtn') ?>" class="dropdown-item">Retur Penjualan</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Receipt') ?>" class="dropdown-item">Pembayaran Customer</a></li>
                                        </ul>
                                    </li>


                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Pembelian</a>
                                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('PurchOrd') ?>" class="dropdown-item">Pesanan Pembelian</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('StockIn') ?>" class="dropdown-item">Penerimaan Barang</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('PurchInv') ?>" class="dropdown-item">Faktur Pembelian<a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('PurchRtn') ?>" class="dropdown-item">Retur Pembelian</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Payment') ?>" class="dropdown-item">Pembayaran Supplier</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>

                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu14" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Persediaan</a>
                                        <ul aria-labelledby="dropdownSubMenu14" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('Kategori') ?>" class="dropdown-item">Kategori</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Barang') ?>" class="dropdown-item">Barang/Jasa</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Adjustment') ?>" class="dropdown-item">Penyesuaian Stok</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu24" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Buku Besar</a>
                                        <ul aria-labelledby="dropdownSubMenu24" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('Currency') ?>" class="dropdown-item">Mata Uang</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Account') ?>" class="dropdown-item">Daftar Perkiraan</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Jurnal') ?>" class="dropdown-item">Bukti Jurnal Umum</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('History') ?>" class="dropdown-item">Histori Buku Besar</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>

                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu8" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Cash Bank</a>
                                        <ul aria-labelledby="dropdownSubMenu8" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('OthRcv') ?>" class="dropdown-item">Penerimaan Kas/Bank</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('OthPay') ?>" class="dropdown-item">Pengeluaran Kas/Bank</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('BankBook') ?>" class="dropdown-item">Buku Bank</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu6" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">Laporan</a>
                                <ul aria-labelledby="dropdownSubMenu6" class="dropdown-menu border-0 text-sm shadow">
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Penjualan</a>
                                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapJual01') ?>" class="dropdown-item">Penjualan Per Periode</a></li>
                                            <li><a href="<?= base_url('LapJual02') ?>" class="dropdown-item">Penjualan Per Customer</a></li>
                                            <li><a href="<?= base_url('LapJual09') ?>" class="dropdown-item">Penjualan Per Salesman</a></li>
                                            <li><a href="<?= base_url('LapJual17') ?>" class="dropdown-item">Penjualan Per Divisi</a></li>
                                            <li><a href="<?= base_url('LapJual03') ?>" class="dropdown-item">Penjualan Per Barang [Rekap]</a></li>
                                            <li><a href="<?= base_url('LapJual18') ?>" class="dropdown-item">Penjualan Per Barang [Detail]</a></li>
                                            <li><a href="<?= base_url('LapJual04') ?>" class="dropdown-item">Penjualan Customer Per Barang</a></li>
                                            <li><a href="<?= base_url('LapJual21') ?>" class="dropdown-item">Gross Profit</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapJual19') ?>" class="dropdown-item">Pembayaran Faktur Per Periode</a></li>
                                            <li><a href="<?= base_url('LapJual05') ?>" class="dropdown-item">Pembayaran Faktur Per Customer</a></li>
                                            <li><a href="<?= base_url('LapJual06') ?>" class="dropdown-item">Ringkasan Mutasi Piutang </a></li>
                                            <li><a href="<?= base_url('LapJual07') ?>" class="dropdown-item">Kartu Piutang</a></li>
                                            <li><a href="<?= base_url('LapJual20') ?>" class="dropdown-item">Ringkasan Umur Piutang</a></li>
                                            <li><a href="<?= base_url('LapJual14') ?>" class="dropdown-item">Rincian Umur Piutang Per Customer</a></li>
                                            <li><a href="<?= base_url('LapJual25') ?>" class="dropdown-item">Rincian Umur Piutang Per Divisi</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapJual22') ?>" class="dropdown-item">Sales Order Per Divisi</a></li>
                                            <li><a href="<?= base_url('LapJual23') ?>" class="dropdown-item">Surat Jalan Per Divisi</a></li>
                                            <li><a href="<?= base_url('LapJual24') ?>" class="dropdown-item">Sales Order Blm Invoice Per Divisi</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapJual26') ?>" class="dropdown-item">Laporan Invoice Uang Muka</a></li>
                                            <li><a href="<?= base_url('LapJual27') ?>" class="dropdown-item">Laporan Invoice [Pajak]</a></li>
                                        </ul>
                                    </li>


                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu7" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Pembelian</a>
                                        <ul aria-labelledby="dropdownSubMenu7" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapBeli01') ?>" class="dropdown-item">Pembelian Per Periode</a></li>
                                            <li><a href="<?= base_url('LapBeli02') ?>" class="dropdown-item">Pembelian Per Supplier</a></li>
                                            <li><a href="<?= base_url('LapBeli10') ?>" class="dropdown-item">Pembelian Per Divisi</a></li>
                                            <li><a href="<?= base_url('LapBeli03') ?>" class="dropdown-item">Pembelian Per Barang</a></li>
                                            <li><a href="<?= base_url('LapBeli04') ?>" class="dropdown-item">Pembelian Supplier Per Barang</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapBeli05') ?>" class="dropdown-item">Pembayaran Faktur Per Supplier</a></li>
                                            <li><a href="<?= base_url('LapBeli06') ?>" class="dropdown-item">Ringkasa Mutasi Hutang</a></li>
                                            <li><a href="<?= base_url('LapBeli07') ?>" class="dropdown-item">Kartu Hutang</a></li>
                                            <li><a href="<?= base_url('LapBeli08') ?>" class="dropdown-item">Rincian Umur Hutang</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu8" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Persediaan</a>
                                        <ul aria-labelledby="dropdownSubMenu8" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapStk03') ?>" class="dropdown-item">Laporan Stock</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk02') ?>" class="dropdown-item">Kartu Stock</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk01') ?>" class="dropdown-item">Laporan Mutasi Stock</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu9" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Keuangan</a>
                                        <ul aria-labelledby="dropdownSubMenu9" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapKeu01') ?>" class="dropdown-item">Buku Besar</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu02') ?>" class="dropdown-item">Neraca Saldo</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu03') ?>" class="dropdown-item">Rugi / Laba</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu04') ?>" class="dropdown-item">Neraca (Ringkasan)</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu05') ?>" class="dropdown-item">Neraca (Rincian)</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu06') ?>" class="dropdown-item">Biaya Per Divisi</a></li>

                                            <!-- <li><a href="<?= base_url('LapKeu05') ?>" class="dropdown-item">LAPORAN PENYUSUTAN AKTIVA TETAP</a></li> -->
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown ">
                                <a id="dropdownSubMenu10" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link  text-white dropdown-toggle">Pengaturan</a>
                                <ul aria-labelledby="dropdownSubMenu10" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('company') ?>" class="dropdown-item">Identitas Perusahaan</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('user/changePassword') ?>" class="dropdown-item">Merubah Password</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('user') ?>" class="dropdown-item">Pemakai</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('counter') ?>" class="dropdown-item">Counter</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('kosong') ?>" class="dropdown-item">Bersihkan Keranjang</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('backup') ?>" class="dropdown-item">Backup Data</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('GantiNoInvoice') ?>" class="dropdown-item">Ganti No Invoice</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('GantiNoSjalan') ?>" class="dropdown-item">Ganti No Srt Jalan</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('GantiNoSo') ?>" class="dropdown-item">Ganti No SO</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('GantiNoPo') ?>" class="dropdown-item">Ganti No PO</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('GantiKodeBarang') ?>" class="dropdown-item">Ganti Kode Barang</a></li>
                                     <li class="dropdown-divider"></li> 
                                    <!-- <li><a href="<?= base_url('posting') ?>" class="dropdown-item">POSTING STOCK BRG JADI</a></li> -->
                                    <li><a href="<?= base_url('loghistory') ?>" class="dropdown-item">Log History</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

                <!--LEVEL2 OPERATOR GUDANG-->

                <?php if (session()->get('level') == "2") { ?>
                    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="<?= base_url('admin') ?>" class="nav-link text-white">Dashboard</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">Daftar</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('Satuan') ?>" class="dropdown-item">Satuan</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Merk') ?>" class="dropdown-item">Merk</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Supplier') ?>" class="dropdown-item">Supplier</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Customer') ?>" class="dropdown-item">Customer</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu5" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">Aktifitas</a>
                                <ul aria-labelledby="dropdownSubMenu5" class="dropdown-menu border-0 text-sm shadow">
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Penjualan</a>
                                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('SalesOrd') ?>" class="dropdown-item">Sales Order</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('SuratJln') ?>" class="dropdown-item">Surat Jalan</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('SalesInv') ?>" class="dropdown-item">Faktur Penjualan</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('SalesRtn') ?>" class="dropdown-item">Retur Penjualan</a></li>
                                        </ul>
                                    </li>


                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Pembelian</a>
                                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('PurchOrd') ?>" class="dropdown-item">Pesanan Pembelian</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('StockIn') ?>" class="dropdown-item">Penerimaan Barang</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('PurchInv') ?>" class="dropdown-item">Faktur Pembelian<a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu14" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Persediaan</a>
                                        <ul aria-labelledby="dropdownSubMenu14" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('Kategori') ?>" class="dropdown-item">Kategori</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Barang') ?>" class="dropdown-item">Barang / Jasa</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Adjustment') ?>" class="dropdown-item">Penyesuaian Stok</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu6" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">Laporan</a>
                                <ul aria-labelledby="dropdownSubMenu6" class="dropdown-menu border-0 text-sm shadow">
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu8" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">INVENTORY</a>
                                        <ul aria-labelledby="dropdownSubMenu8" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapStk01') ?>" class="dropdown-item">Persediaan Barang</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk02') ?>" class="dropdown-item">Kartu Stok</a></li>
                                            <li class="dropdown-divider"></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item dropdown ">
                                <a id="dropdownSubMenu10" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link  text-white dropdown-toggle">Pengaturan</a>
                                <ul aria-labelledby="dropdownSubMenu10" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('user/changePassword') ?>" class="dropdown-item">Merubah Password</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

            <?php } ?>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto mr-5">
                <?php if (session()->get('username') == "") { ?>
                    <li class="nav navbar-nav-item">
                        <a href="<?= base_url('auth') ?>" class="nav-link"><i class="fa fa-sign-in-alt"></i> Login</a>
                    </li>
                <?php } else { ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= base_url('fotouser/' . session()->get('foto')) ?>" class="img-circle" width="40px" height="40px">
                            <span class="hidden-xs text-light "><?= session()->get('fullname') ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                                <img src="<?= base_url('fotouser/' . session()->get('foto')) ?>" class="img-circle" width="50px" height="50px">
                                <p>
                                    <?= session()->get('fullname') ?>
                                    <small><?= date('d M Y') ?></small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="text-center">
                                    <a href="#" class="btn btn-success btn-sm">Profile</a>
                                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger btn-sm"><i class="fa fa-sign-in"></i> Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <!-- </div> -->
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="mx-5">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <!-- /.content-wrapper -->



        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                <!-- @MSI-2023 -->
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/assets/dist/js/demo.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/AutoNumeric.js"></script>
    <script src="<?= base_url('') ?>/assets/sweetalert2/sweetalert2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>



    <!-- Page specific script -->

    <script>
        $(function() {
            $("#example0").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
            $('#example1').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "lengthChange": true,
            });

            $('#example3').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "lengthChange": true,
            });
            $('#example5').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "lengthChange": true,
            });
            $('#example7').DataTable({
                "paging": true,
                "searching": true,
                "pageLength": 18,
                "info": true,
                "autoWidth": false,
                "lengthChange": true,
            });
        });

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>

    <script>
        function bacaGambar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#gambar_load').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        function number_format2(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split(',');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }


        // Number Only
        $('.number_only').keypress(function(e) {
            return isNumbers(e, this);
        });

        function isNumbers(evt, element) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

    <script>
        // $(document).ready(function() {
        function autonum() {
            $('.autonum').autoNumeric('init', {
                aSep: ',',
                aDec: '.',
                mDec: '0'
            });
            $('.autonum2').autoNumeric('init', {
                aSep: ',',
                aDec: '.',
                mDec: '2'
            });
        }
        autonum();
        // });
    </script>

    <script>
        window.setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 1500);
    </script>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    
    <script>
        $(document).ready(function(){
            $('#show_purchreq').addClass('add-scroll');
            
        });
        $(function() {
            $('#preq').DataTable({
            paging: false,
            ordering: false,
            scrollCollapse: true,
            scrollY: '500px',
            bPaginate: false,
            bFilter: false,
            bInfo: false,
            "language": {
                "emptyTable": " "
                }        
            });
        });
    </script>
    
</body>

</html>