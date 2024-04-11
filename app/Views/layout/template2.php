<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BERKAT ARTA PRIMA</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/mycss.css"> -->
    <link href="<?= base_url('') ?>/assets/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= base_url('') ?>/assets/sweetalert2/animate.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <style>
        .swal2-popup {
            font-size: 0.7rem !important;
        }
    </style>
    <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition layout-top-nav" style="font-family: 'Domine', serif;font-size: 14px;">
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

                <!--LEVEL-1-->
                <?php if (session()->get('level') == "1") { ?>
                    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="<?= base_url('admin') ?>" class="nav-link text-white">DASHBOARD</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">TABEL</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('Satuan') ?>" class="dropdown-item">SATUAN</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Merk') ?>" class="dropdown-item">MERK</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Kategori') ?>" class="dropdown-item">KATEGORI</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Barang') ?>" class="dropdown-item">BARANG</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Supplier') ?>" class="dropdown-item">SUPPLIER</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Customer') ?>" class="dropdown-item">CUSTOMER</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('Account') ?>" class="dropdown-item">PERKIRAAN</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu5" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">TRANSAKSI</a>
                                <ul aria-labelledby="dropdownSubMenu5" class="dropdown-menu border-0 text-sm shadow">
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PENJUALAN</a>
                                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                        <li><a href="<?= base_url('SuratJln') ?>" class="dropdown-item">SURAT JALAN</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><a href="<?= base_url('SalesInv') ?>" class="dropdown-item">INVOICE</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><a href="<?= base_url('SalesRtn') ?>" class="dropdown-item">RETUR PENJUALAN</a></li>
                                        </ul>
                                    </li>


                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PEMBELIAN</a>
                                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 text-sm shadow">
                                             <li><a href="<?= base_url('PurchOrd') ?>" class="dropdown-item">ORDER PEMBELIAN [PO]</a></li> 
                                             <li class="dropdown-divider"></li> 
                                            <li><a href="<?= base_url('PurchInv') ?>" class="dropdown-item">FAKTUR PEMBELIAN</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('PurchRtn') ?>" class="dropdown-item">RETUR PEMBELIAN</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu14" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">INVENTORY</a>
                                        <ul aria-labelledby="dropdownSubMenu14" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('MasukBaku') ?>" class="dropdown-item">PEMASUKKAN BAHAN BAKU</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('PakaiBaku') ?>" class="dropdown-item">PEMAKAIAN BAHAN BAKU LAIN2</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Hasil') ?>" class="dropdown-item">HASIL PRODUKSI BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Adjbarang') ?>" class="dropdown-item">PENYESUAIAN STOCK BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Adjustment') ?>" class="dropdown-item">PENYESUAIAN STOCK BAHAN BAKU</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>

                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu5" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">KEUANGAN</a>
                                        <ul aria-labelledby="dropdownSubMenu5" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('Receipt') ?>" class="dropdown-item">PELUNASAN CUSTOMER</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Payment') ?>" class="dropdown-item">PEMBAYARAN SUPPLIER</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('OthRcv') ?>" class="dropdown-item">BUKTI PENERIMAAN KAS/BANK</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('OthPay') ?>" class="dropdown-item">BUKTI PENGELUARAN KAS/BANK</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Jurnal') ?>" class="dropdown-item">JURNAL MEMORIAL</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('TandaTerima') ?>" class="dropdown-item">TANDA TERIMA FAKTUR</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu6" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">LAPORAN</a>
                                <ul aria-labelledby="dropdownSubMenu6" class="dropdown-menu border-0 text-sm shadow">
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PENJUALAN</a>
                                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapJual01') ?>" class="dropdown-item">LAPORAN PENJUALAN PER PERIODE</a></li>
                                            <li><a href="<?= base_url('LapJual02') ?>" class="dropdown-item">LAPORAN PENJUALAN PER CUSTOMER</a></li>
                                            <li><a href="<?= base_url('LapJual09') ?>" class="dropdown-item">LAPORAN PENJUALAN PER SALESMAN</a></li>
                                            <li><a href="<?= base_url('LapJual03') ?>" class="dropdown-item">LAPORAN PENJUALAN PER BARANG</a></li>
                                            <li><a href="<?= base_url('LapJual04') ?>" class="dropdown-item">REKAP PENJUALAN BARANG PER CUSTOMER</a></li>
                                            <li><a href="<?= base_url('LapJual10') ?>" class="dropdown-item">REKAP PENJUALAN BARANG PER SALESMAN</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapJual19') ?>" class="dropdown-item">LAPORAN PELUNASAN PER PERIODE</a></li>
                                            <li><a href="<?= base_url('LapJual05') ?>" class="dropdown-item">LAPORAN PELUNASAN PER CUSTOMER</a></li>
                                            <li><a href="<?= base_url('LapJual12') ?>" class="dropdown-item">LAPORAN PELUNASAN PER SALESMAN</a></li>
                                            <li><a href="<?= base_url('LapJual06') ?>" class="dropdown-item">LAPORAN SALDO PIUTANG</a></li>
                                            <li><a href="<?= base_url('LapJual07') ?>" class="dropdown-item">LAPORAN KARTU PIUTANG</a></li>
                                            <li><a href="<?= base_url('LapJual14') ?>" class="dropdown-item">LAPORAN UMUR PIUTANG PER CUSTOMER</a></li>
                                            <li><a href="<?= base_url('LapJual15') ?>" class="dropdown-item">LAPORAN UMUR PIUTANG PER SALESMAN</a></li>
                                            <li><a href="<?= base_url('LapJual16') ?>" class="dropdown-item">LAPORAN TANDA TERIMA</a></li>
                                        </ul>
                                    </li>


                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu7" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PEMBELIAN</a>
                                        <ul aria-labelledby="dropdownSubMenu7" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapBeli01') ?>" class="dropdown-item">LAPORAN PEMBELIAN PER PERIODE</a></li>
                                            <li><a href="<?= base_url('LapBeli02') ?>" class="dropdown-item">LAPORAN PEMBELIAN PER SUPPLIER</a></li>
                                            <li><a href="<?= base_url('LapBeli03') ?>" class="dropdown-item">LAPORAN PEMBELIAN PER BARANG</a></li>
                                            <li><a href="<?= base_url('LapBeli04') ?>" class="dropdown-item">REKAP PEMBELIAN BARANG PER SUPPLIER</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapBeli05') ?>" class="dropdown-item">LAPORAN PEMBAYARAN PER SUPPLIER</a></li>
                                            <li><a href="<?= base_url('LapBeli06') ?>" class="dropdown-item">LAPORAN SALDO HUTANG</a></li>
                                            <li><a href="<?= base_url('LapBeli07') ?>" class="dropdown-item">LAPORAN KARTU HUTANG</a></li>
                                            <li><a href="<?= base_url('LapBeli08') ?>" class="dropdown-item">LAPORAN OUTSTANDING PER SUPPLIER</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu19" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PRODUKSI</a>
                                        <ul aria-labelledby="dropdownSubMenu19" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapProd01') ?>" class="dropdown-item">LAPORAN PEMAKAIAN BAHAN</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapProd02') ?>" class="dropdown-item">LAPORAN HASIL PRODUKSI</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu8" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">STOCK</a>
                                        <ul aria-labelledby="dropdownSubMenu8" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapStk01') ?>" class="dropdown-item">STOCK BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk02') ?>" class="dropdown-item">KARTU STOCK BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk03') ?>" class="dropdown-item">STOCK BAHAN BAKU</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk04') ?>" class="dropdown-item">KARTU STOCK BAHAN BAKU</a></li>

                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu9" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">KEUANGAN</a>
                                        <ul aria-labelledby="dropdownSubMenu9" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapKeu01') ?>" class="dropdown-item">LAPORAN BUKU BESAR</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu02') ?>" class="dropdown-item">LAPORAN NERACA SALDO</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu03') ?>" class="dropdown-item">LAPORAN RUGI LABA</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapKeu04') ?>" class="dropdown-item">LAPORAN NERACA</a></li>
                                            <!-- <li class="dropdown-divider"></li> -->
                                            <!-- <li><a href="<?= base_url('LapKeu05') ?>" class="dropdown-item">LAPORAN PENYUSUTAN AKTIVA TETAP</a></li> -->
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown ">
                                <a id="dropdownSubMenu10" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link  text-white dropdown-toggle">SETUP</a>
                                <ul aria-labelledby="dropdownSubMenu10" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('company') ?>" class="dropdown-item">INDENTITAS PERUSAHAAN</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('user/changePassword') ?>" class="dropdown-item">GANTI PASSWORD</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('user') ?>" class="dropdown-item">DATA USERS</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('counter') ?>" class="dropdown-item">SET COUNTER</a></li>
                                    <!-- <li class="dropdown-divider"></li> -->
                                    <!-- <li><a href="<?= base_url('posting') ?>" class="dropdown-item">POSTING STOCK BRG JADI</a></li> -->
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

                <!--LEVEL-2-->

                <?php if (session()->get('level') == "2") { ?>
                    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">TABEL</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('satuan') ?>" class="dropdown-item">SATUAN</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('baku') ?>" class="dropdown-item">BAHAN BAKU</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('barang') ?>" class="dropdown-item">BARANG JADI</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('supplier') ?>" class="dropdown-item">SUPPLIER</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('salesman') ?>" class="dropdown-item">SALESMAN</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?= base_url('customer') ?>" class="dropdown-item">CUSTOMER</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu5" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link text-white dropdown-toggle">TRANSAKSI</a>
                                <ul aria-labelledby="dropdownSubMenu5" class="dropdown-menu border-0 text-sm shadow">
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PENJUALAN</a>
                                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('SalesInv/index2') ?>" class="dropdown-item">SURAT JALAN</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PEMBELIAN</a>
                                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('PurchInv') ?>" class="dropdown-item">FAKTUR PEMBELIAN</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('PurchRtn') ?>" class="dropdown-item">RETUR PEMBELIAN</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu14" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">INVENTORY</a>
                                        <ul aria-labelledby="dropdownSubMenu14" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('MasukBaku') ?>" class="dropdown-item">PEMASUKKAN BAHAN BAKU</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('PakaiBaku') ?>" class="dropdown-item">PEMAKAIAN BAHAN BAKU LAIN2</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Hasil') ?>" class="dropdown-item">HASIL PRODUKSI BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Adjbarang') ?>" class="dropdown-item">PENYESUAIAN STOCK BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('Adjustment') ?>" class="dropdown-item">PENYESUAIAN STOCK BAHAN BAKU</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li class="dropdown-divider"></li>

                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu5" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">KEUANGAN</a>
                                        <ul aria-labelledby="dropdownSubMenu5" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('OthRcv') ?>" class="dropdown-item">BUKTI PENERIMAAN KAS/BANK</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('OthPay') ?>" class="dropdown-item">BUKTI PENGELUARAN KAS/BANK</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="nav-item dropdown">
                                <a id="dropdownSubMenu6" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-white">LAPORAN</a>
                                <ul aria-labelledby="dropdownSubMenu6" class="dropdown-menu border-0 text-sm shadow">

                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu19" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PRODUKSI</a>
                                        <ul aria-labelledby="dropdownSubMenu19" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapProd01') ?>" class="dropdown-item">LAPORAN PEMAKAIAN BAHAN</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapProd02') ?>" class="dropdown-item">LAPORAN HASIL PRODUKSI</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-submenu dropdown-hover ">
                                        <a id="dropdownSubMenu8" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">STOCK</a>
                                        <ul aria-labelledby="dropdownSubMenu8" class="dropdown-menu border-0 text-sm shadow">
                                            <li><a href="<?= base_url('LapStk01') ?>" class="dropdown-item">STOCK BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk02') ?>" class="dropdown-item">KARTU STOCK BARANG JADI</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk03') ?>" class="dropdown-item">STOCK BAHAN BAKU</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?= base_url('LapStk04') ?>" class="dropdown-item">KARTU STOCK BAHAN BAKU</a></li>

                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item dropdown ">
                                <a id="dropdownSubMenu10" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-white">SETUP</a>
                                <ul aria-labelledby="dropdownSubMenu10" class="dropdown-menu border-0 text-sm shadow">
                                    <li><a href="<?= base_url('user/changePassword') ?>" class="dropdown-item">GANTI PASSWORD</a></li>
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
                @BAP-2023
            </div>
            <!-- <strong>Copyright &copy; 2022 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved. -->
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


</body>
</html>