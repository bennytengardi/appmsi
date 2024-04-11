<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<section class="content-header">
</section>
<div class="container">
    <?php if (session()->get('level') == "1") { ?>
        <h5>DASHBOARD</h5>
        <br>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <?php if ($jual != null) { ?>
                            <h4>Rp <?= number_format($jual['total']) ?></h4>
                        <?php } else { ?>
                            <h4>Rp 0</h4>
                        <?php } ?>
                        <p>Penjualan Hari Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
    
                </div>
            </div>
    
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <?php if ($jualbln != null) { ?>
                            <h4>Rp <?= number_format($jualbln['totalbln']) ?></h4>
                        <?php } else { ?>
                            <h4>Rp 0</h4>
                        <?php } ?>
                        <p>Penjualan Bln Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <?php if ($belibln != null) { ?>
                            <h4>Rp <?= number_format($belibln['totalbln']) ?></h4>
                        <?php } else { ?>
                            <h4>Rp 0</h4>
                        <?php } ?>
    
                        <p>Pembelian Bln Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-truck"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <?php if ($biayabln != null) { ?>
                            <h4>Rp <?= number_format($biayabln['totalbln']) ?></h4>
                        <?php } else { ?>
                            <h4>Rp 0</h4>
                        <?php } ?>
                        <p>Biaya Bulan Ini</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-copy"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    <?php } ?>

</div>
<?= $this->endSection() ?>