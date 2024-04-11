<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesman;
use App\Models\ModelDataCustomer;
use App\Models\ModelBarang;
use App\Models\ModelSalesInv;
use App\Models\ModelDataSalesInv;
use App\Models\ModelCounter;
use App\Models\ModelDataBrg;
use App\Models\ModelDivisi;
use App\Models\ModelJurnal;

// use CodeIgniter\CLI\Console;
use Config\Services;

class PostingJurnal extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelSalesman = new ModelSalesman();
        $this->ModelDivisi   = new ModelDivisi();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelJurnal   = new ModelJurnal();
    }

    public function index()
    {
        $msalesinv = $this->ModelSalesInv->allData3();

        foreach ($msalesinv as $row) :

            if ($row['kodejual'] == 'SALES') {
                $codejurnal = 'Sales Invoice';
                $keterangan = 'PENJUALAN - ' . $row['nama_customer'];
                $data1 = [
                    'no_voucher'     => $row['no_invoice'],
                    'tgl_voucher'    => $row['tgl_invoice'],
                    'kode_account'   => '1103.001',
                    'debet'          => $row['total_invoice'],
                    'prime_debet'    => $row['total_invoice'],
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'rate'           => 1,
                    'keterangan'     => $row['keterangan'],
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data1);

                if ($row['total_dp'] > 0) {
                    $data0 = [
                        'no_voucher'     => $row['no_invoice'],
                        'tgl_voucher'    => $row['tgl_invoice'],
                        'kode_account'   => '2105.001',
                        'debet'          => $row['total_dp'],
                        'prime_debet'    => $row['total_dp'],
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'rate'           => 1,
                        'keterangan'     => $row['keterangan'],
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data0);
                }

                $data2 = [
                    'no_voucher'     => $row['no_invoice'],
                    'tgl_voucher'    => $row['tgl_invoice'],
                    'kode_account'   => $row['kode_accjual'],
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'credit'         => $row['total_amount'] - $row['total_discount'],
                    'prime_credit'   => $row['total_amount'] - $row['total_discount'],
                    'rate'           => 1,
                    'keterangan'     => $row['keterangan'],
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data2);

                if ($row['total_ppn'] > 0) {
                    $data3 = [
                        'no_voucher'     => $row['no_invoice'],
                        'tgl_voucher'    => $row['tgl_invoice'],
                        'kode_account'   => '2104.005',
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $row['total_ppn'],
                        'prime_credit'   => $row['total_ppn'],
                        'rate'           => 1,
                        'keterangan'     => $row['keterangan'],
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data3);
                }
                
                if ($row['total_hpp'] > 0) {
                    $data4 = [
                        'no_voucher'     => $row['no_invoice'],
                        'tgl_voucher'    => $row['tgl_invoice'],
                        'kode_account'   => $row['kode_acchpp'],
                        'debet'          => $row['total_hpp'],
                        'prime_debet'    => $row['total_hpp'],
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'rate'           => 1,
                        'keterangan'     => $row['keterangan'],
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data4);
    
                    $data5 = [
                        'no_voucher'     => $row['no_invoice'],
                        'tgl_voucher'    => $row['tgl_invoice'],
                        'kode_account'   => $row['kode_accinv'],
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $row['total_hpp'],
                        'prime_credit'   => $row['total_hpp'],
                        'rate'           => 1,
                        'keterangan'     => $row['keterangan'],
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data5);
                }

                if ($row['ongkir'] > 0) {
                    $data6 = [
                        'no_voucher'     => $row['no_invoice'],
                        'tgl_voucher'    => $row['tgl_invoice'],
                        'kode_account'   => '6108.003',
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $row['ongkir'],
                        'prime_credit'   => $row['ongkir'],
                        'rate'           => 1,
                        'keterangan'     => $row['keterangan'],
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data6);
                }
            } else {
                $codejurnal = 'Sales Invoice';
                $keterangan = 'UANG MUKA - ' . $row['nama_customer'];
                $data1 = [
                    'no_voucher'     => $row['no_invoice'],
                    'tgl_voucher'    => $row['tgl_invoice'],
                    'kode_account'   => '1103.001',
                    'debet'          => $row['total_invoice'],
                    'prime_debet'    => $row['total_invoice'],
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'rate'           => 1,
                    'keterangan'     => $row['keterangan'],
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data1);

                if ($row['total_ppn'] > 0) {
                    $data3 = [
                        'no_voucher'     => $row['no_invoice'],
                        'tgl_voucher'    => $row['tgl_invoice'],
                        'kode_account'   => '2104.005',
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $row['total_ppn'],
                        'prime_credit'   => $row['total_ppn'],
                        'rate'           => 1,
                        'keterangan'     => $row['keterangan'],
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data3);
                }
                
                $data0 = [
                    'no_voucher'     => $row['no_invoice'],
                    'tgl_voucher'    => $row['tgl_invoice'],
                    'kode_account'   => '2105.001',
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'credit'         => $row['total_dpp'],
                    'prime_credit'   => $row['total_dpp'],
                    'rate'           => 1,
                    'keterangan'     => $row['keterangan'],
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data0);
            }
        endforeach;
    }
}
