<?php

namespace App\Controllers;

use App\Models\ModelJurnal;
use App\Models\ModelAccount;
use App\Models\ModelBankBook;
use Config\Services;

class BankBook extends BaseController
{
    public function __construct()
    {
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelAccount  = new ModelAccount();
        $this->ModelBankBook = new ModelBankBook();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlbb', $date);
        session()->set('tglakhbb', date('Y-m-d'));
        session()->set('acctbb', '');
        $data = [
            'account'    => $this->ModelAccount->allDataBank(),
            'dari'       => $date,
            'sampai'     => date("Y-m-d"),
        ];
        return view('bankbook/v_index', $data);
    }

    public function proses()
    {
        $dari      = $this->request->getPost('tgl1');
        $sampai    = $this->request->getPost('tgl2');
        $kodeacct  = $this->request->getPost('acct');
        $data = [
            'kode_account' => $kodeacct,
            'awldbt' => 0,
            'awlcrd' => 0,
            'crd'    => 0,
            'dbt'    => 0
        ];


        $this->ModelAccount->clearSaldo($data);
        $awl = $this->ModelBankBook->awalSaldo($dari, $kodeacct);
        if ($awl) {
            $acct   = $awl['kode_account'];
            $debet  = $awl['awaldbt'];
            $credit = $awl['awalcrd'];
            $raw1 = [
                'kode_account' => $acct,
                'awldbt' => $debet,
                'awlcrd' => $credit,
            ];
            $this->ModelBankBook->updateSaldoAwal($raw1);
        }

        $this->ModelBankBook->clearBukuBesar();
        
        $dacct = $this->ModelAccount->detail($kodeacct);
        $tglbukti  = date('Y-m-d', strtotime('-1 days', strtotime($dari)));
        $nobukti   = '';
        if ($dacct['currency'] == "IDR") {
            $nilai     = $dacct['saldo_awal'] + $dacct['awldbt'] - $dacct['awlcrd'];
        } else {
            $nilai     = $dacct['prime_awal'] + $dacct['awldbt'] - $dacct['awlcrd'];
        }

        $raw1 = [
            'tgl_bukti'     => $tglbukti,
            'no_bukti'      => $nobukti,
            'keterangan'    => 'Beginning Balance',
            'kode_account'  => $kodeacct,
            'debet'         => 0,
            'credit'        => 0,
            'saldo'         => $nilai
        ];
        $this->ModelBankBook->insertBukuBesar($raw1);


        $transaksi = $this->ModelBankBook->trx($dari, $sampai, $kodeacct);
        foreach ($transaksi as $trans1) {
            $tglbukti  = $trans1['tgl_voucher'];
            $nobukti   = $trans1['no_voucher'];
            $keterangan = $trans1['keterangan'];
            $acct       = $trans1['kode_account'];
            $debet      = $trans1['prime_debet'];
            $credit     = $trans1['prime_credit'];
            $pos        = $trans1['position'];
            $rectype = 1;
            if ($pos == 'DB' && $debet != 0) {
                $rectype = 1;
            }
            if ($pos == 'DB' && $credit != 0) {
                $rectype = 2;
            }
            if ($pos == 'CR' && $credit != 0) {
                $rectype = 1;
            }
            if ($pos == 'CR' && $debet != 0) {
                $rectype = 2;
            }
            $raw2 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_account'  => $acct,
                'debet'         => $debet,
                'credit'        => $credit,
                'rectype'       => $rectype
            ];
            $this->ModelBankBook->insertBukuBesar($raw2);
        }
        $data = $this->ModelBankBook->getBukuBesar();
        echo json_encode($data);
    }
 }
