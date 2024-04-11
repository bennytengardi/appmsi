<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelBarang;
use App\Models\ModelPurchInv;
use App\Models\ModelDataPurchInv;
use App\Models\ModelCounter;
use App\Models\ModelDataBrg;
use App\Models\ModelJurnal;
use App\Models\ModelDivisi;

// use CodeIgniter\CLI\Console;
use Config\Services;

class PostingJurnal2 extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelDivisi   = new ModelDivisi();
    }

    public function index()
    {
        $mpurchinv = $this->ModelPurchInv->allData3();

        foreach ($mpurchinv as $row) :

            $codejurnal = 'Purchase Invoice';
            $keterangan = 'PEMBELIAN DARI: ' . $row['nama_supplier'];

            $data1 = [
                'no_voucher'     => $row['no_invoice'],
                'tgl_voucher'    => $row['tgl_invoice'],
                'kode_account'   => '2101.001',
                'debet'          => 0,
                'prime_debet'    => 0,
                'credit'         => $row['total_invoice'] * $row['kurs'],
                'prime_credit'   => $row['total_invoice'],
                'rate'           => $row['kurs'],
                'keterangan'     => $row['keterangan'],
                'codejurnal'     => $codejurnal,
            ];
            $this->ModelJurnal->add_detail($data1);

            $data2 = [
                'no_voucher'     => $row['no_invoice'],
                'tgl_voucher'    => $row['tgl_invoice'],
                'kode_account'   => $row['kode_accinv'],
                'debet'          => $row['total_dpp'] * $row['kurs'],
                'prime_debet'    => $row['total_dpp'],
                'credit'         => 0,
                'prime_credit'   => 0,
                'rate'           => $row['kurs'],
                'keterangan'     => $row['keterangan'],
                'codejurnal'     => $codejurnal,
            ];
            $this->ModelJurnal->add_detail($data2);
            if ($row['total_ppn'] > 0) {
                $data3 = [
                    'no_voucher'     => $row['no_invoice'],
                    'tgl_voucher'    => $row['tgl_invoice'],
                    'kode_account'   => '1106.001',
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'debet'          => $row['total_ppn'] * $row['kurs'],
                    'prime_debet'    => $row['total_ppn'],
                    'rate'           => $row['kurs'],
                    'keterangan'     => $row['keterangan'],
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data3);
            }    

        endforeach;
    }
}
