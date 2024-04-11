<?php

namespace App\Controllers;

use App\Models\ModelJurnal;
use App\Models\ModelAccount;
use App\Models\ModelBankBook;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        // print_r($transaksi);
        foreach ($transaksi as $trans1) {
            $tglbukti  = $trans1['tgl_voucher'];
            $nobukti   = $trans1['no_voucher'];
            $keterangan = $trans1['keterangan'];
            $acct       = $trans1['kode_account'];
            if ($trans1['currency'] == 'IDR') {
                $debet      = $trans1['debet'];
                $credit     = $trans1['credit'];
            } else {
                $debet      = $trans1['prime_debet'];
                $credit     = $trans1['prime_credit'];
            };            
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
    
    public function print_laporan()
    {
        $laporan = $this->ModelBankBook->getBukuBesar();
        $dari   = $this->request->getVar('dari');
        $sampai = $this->request->getVar('sampai');
        $title = "BUKU BANK/KAS";
        $data = array(
            'laporan' => $laporan,
            'title' => $title,
            'dari'  => $dari,
            'sampai' => $sampai,
            'title1' => session()->get('nama_company')
        );
        return view('bankbook/print_laporan', $data);
    }
    
    public function excel()
    {
        $laporan = $this->ModelBankBook->getBukuBesar();
        $dari   = $this->request->getVar('dari');
        $sampai = $this->request->getVar('sampai');
        $title = "BUKU BANK/KAS";
        $title1 = session()->get('nama_company');
        $data = array(
            'laporan' => $laporan,
            'title' => $title,
            'dari'  => $dari,
            'sampai' => $sampai,
        );

        $spreadsheet = new Spreadsheet;
        $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
        $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
        $spreadsheet->getActiveSheet()->mergeCells('A3:F3');

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

        $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

        $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFill()->getStartColor()->setARGB('FF4F81BD');
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')
            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(60);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'TANGGAL');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO VOUCHER');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'KETERANGAN');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'DEBET');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'CREDIT');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'SALDO');


        $kolom = 6;
        $totdbt = 0;
        $totcrd = 0;
        $saldo = 0;
        $sw = 0;
        $kdcust = '';
        // DETAIL

        foreach ($laporan as $lap) {
            if ($kdcust <> $lap['kode_account']) {
                if ($sw == 1) {
                    $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

                    $kolom = $kolom + 1;
                    $totdbt = 0;
                    $totcrd = 0;
                }

                $kolom = $kolom + 1;
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_account']);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(14);
                $kdcust = $lap['kode_account'];
                $saldo  = $lap['saldo'];
                $kolom  = $kolom + 1;
            }

            $totdbt = $totdbt + $lap['debet'];
            $totcrd = $totcrd + $lap['credit'];
            if ($lap['position'] == 'DB') {
                $saldo  = $saldo + $lap['debet'] - $lap['credit'];
            } else {
                $saldo = $saldo + $lap['credit'] - $lap['debet'];
            }
            $sw = 1;

            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-M-Y', strtotime($lap['tgl_bukti'])));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['no_bukti']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['keterangan']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['debet']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['credit']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $saldo);
            $kolom++;
        }

        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'lapkeu01' .  '.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename = ' . $filename . '');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');
        exit;

    }

 }
