<?php

namespace App\Controllers;

use App\Models\ModelAccount;
use App\Models\ModelJurnal;
use App\Models\ModelLapKeu01;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapKeu01 extends BaseController
{
    function __construct()
    {
        $this->ModelAccount  = new ModelAccount();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelLapKeu01 = new ModelLapKeu01();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Buku Besar',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'account' => $this->ModelAccount->allDataDetail(),
        ];
        return view('lapkeu01/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodeacct  = $this->request->getPost('kode_account');
        $kodeacct2  = $this->request->getPost('kode_account2');

        $title = "LAPORAN BUKU BESAR";
        $title1 = session()->get('nama_company');
        $account = $this->ModelAccount->allDataRange($kodeacct, $kodeacct2);
        foreach ($account as $acc) {
            $data = [
                'kode_account' => $acc['kode_account'],
                'awldbt' => 0,
                'awlcrd' => 0,
                'crd' => 0,
                'dbt' => 0
            ];
            $this->ModelAccount->clearSaldo($data);
        }

        $awl = $this->ModelLapKeu01->awalSaldo($dari, $kodeacct, $kodeacct2);
        foreach ($awl as $aw1) {
            $acct = $aw1['kode_account'];
            $debet = $aw1['awaldbt'];
            $credit = $aw1['awalcrd'];
            $raw1 = [
                'kode_account' => $acct,
                'awldbt' => $debet,
                'awlcrd' => $credit,
            ];
            $this->ModelLapKeu01->updateSaldoAwal($raw1);
        }
        $this->ModelLapKeu01->clearBukuBesar();

        $dacct = $this->ModelAccount->allDataRange($kodeacct, $kodeacct2);

        foreach ($dacct as $aw3) {

            // if ($aw3['saldo_awal'] != 0) {
            $tglbukti  = date('Y-m-d', strtotime('-1 days', strtotime($dari)));
            $nobukti   = '';
            $acct      = $aw3['kode_account'];
            if ($aw3['position'] == 'DB') {
                $nilai     = $aw3['saldo_awal'] + $aw3['awldbt'] - $aw3['awlcrd'];
            } else {
                $nilai = $aw3['saldo_awal'] + $aw3['awlcrd'] - $aw3['awldbt'];
            }
            $raw1 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => 'Saldo Awal',
                'kode_account'  => $acct,
                'debet'         => 0,
                'credit'        => 0,
                'saldo'         => $nilai
            ];

            $this->ModelLapKeu01->insertBukuBesar($raw1);
            // }
        }


        $transaksi = $this->ModelLapKeu01->trx($dari, $sampai, $kodeacct, $kodeacct2);
        foreach ($transaksi as $trans1) {
            $tglbukti  = $trans1['tgl_voucher'];
            $nobukti   = $trans1['no_voucher'];
            $keterangan = $trans1['keterangan'];
            $acct       = $trans1['kode_account'];
            $debet      = $trans1['debet'];
            $credit     = $trans1['credit'];
            $pos        = $trans1['position'];

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
            $this->ModelLapKeu01->insertBukuBesar($raw2);
        }

        $laporan = $this->ModelLapKeu01->getBukuBesar();
        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapkeu01/tampil', $data);
        }

        if (isset($tombolExport)) {
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
}
