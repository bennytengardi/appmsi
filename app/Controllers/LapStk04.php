<?php

namespace App\Controllers;

use App\Models\ModelBaku;
use App\Models\ModelLapStk04;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapStk04 extends BaseController
{
    function __construct()
    {
        $this->ModelBaku = new ModelBaku();
        $this->ModelLapStk04 = new ModelLapStk04();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Kartu Stok',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'baku' => $this->ModelBaku->alldata(),
        ];
        return view('lapstk04/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');

        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodebaku  = $this->request->getPost('kode_baku');

        $title = "LAPORAN KARTU STOCK";
        $baku = $this->ModelBaku->allData();
        foreach ($baku as $bak) {
            $data = [
                'kode_baku' => $bak['kode_baku'],
                'awldbt' => 0,
                'awldbt2' => 0,
                'awlcrd' => 0,
                'awlcrd2' => 0,
                'awlcrd3' => 0,
                'awlcrd4' => 0,
                'crd'  => 0,
                'crd2' => 0,
                'crd3' => 0,
                'crd4' => 0,
                'dbt'  => 0,
                'dbt2' => 0,
            ];
            $this->ModelBaku->clearSaldo($data);
        }

        $awldbt = $this->ModelLapStk04->awalDebet($dari, $kodebaku);
        foreach ($awldbt as $aw1) {
            $baku = $aw1['kode_baku'];
            $nilai = $aw1['awldbt'];
            $raw1 = [
                'kode_baku' => $baku,
                'awldbt' => $nilai
            ];
            $this->ModelLapStk04->updateSaldoAwal($raw1);
        }

        $awldbt2 = $this->ModelLapStk04->awalDebet2($dari, $kodebaku);
        foreach ($awldbt2 as $aw1) {
            $baku = $aw1['kode_baku'];
            $nilai = $aw1['awldbt2'];
            $raw1 = [
                'kode_baku' => $baku,
                'awldbt2' => $nilai
            ];
            $this->ModelLapStk04->updateSaldoAwal($raw1);
        }


        $awlcrd = $this->ModelLapStk04->awalCredit($dari, $kodebaku);
        foreach ($awlcrd as $aw2) {
            $baku = $aw2['kode_baku'];
            $nilai = $aw2['awlcrd'];
            $raw1 = [
                'kode_baku' => $baku,
                'awlcrd' => $nilai
            ];
            $this->ModelLapStk04->updateSaldoAwal($raw1);
        }

        $awlcrd2 = $this->ModelLapStk04->awalCredit2($dari, $kodebaku);
        foreach ($awlcrd2 as $aw2) {
            $baku = $aw2['kode_baku'];
            $nilai = $aw2['awlcrd2'];
            $raw1 = [
                'kode_baku' => $baku,
                'awlcrd2' => $nilai
            ];
            $this->ModelLapStk04->updateSaldoAwal($raw1);
        }

        $awlcrd3 = $this->ModelLapStk04->awalCredit3($dari, $kodebaku);
        foreach ($awlcrd3 as $aw2) {
            $baku = $aw2['kode_baku'];
            $nilai = $aw2['awlcrd3'];
            $raw1 = [
                'kode_baku' => $baku,
                'awlcrd3' => $nilai
            ];
            $this->ModelLapStk04->updateSaldoAwal($raw1);
        }

        $awlcrd4 = $this->ModelLapStk04->awalCredit4($dari, $kodebaku);
        foreach ($awlcrd4 as $aw2) {
            $baku = $aw2['kode_baku'];
            $nilai = $aw2['awlcrd4'];
            $raw1 = [
                'kode_baku' => $baku,
                'awlcrd4' => $nilai
            ];
            $this->ModelLapStk04->updateSaldoAwal($raw1);
        }

        $this->ModelLapStk04->clearKartuStock();
        if ($kodebaku == "ALL") {
            $dbaku = $this->ModelBaku->allData();
        } else {
            $dbaku = $this->ModelBaku->getBaku($kodebaku);
        }

        foreach ($dbaku as $aw3) {
            $tglbukti  = date('Y-m-d', strtotime('-1 days', strtotime($dari)));
            $nobukti   = '';
            $rectype   = '1';
            $baku      = $aw3['kode_baku'];
            $nilai     =  $aw3['awal'] + $aw3['awldbt'] + $aw3['awldbt2'] - $aw3['awlcrd'] - $aw3['awlcrd2'] - $aw3['awlcrd3'] - $aw3['awlcrd4'];
            $raw1 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => 'Saldo Awal',
                'kode_baku'     => $baku,
                'balance'       => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk04->insertKartuStock($raw1);
        }

        $trxdbt = $this->ModelLapStk04->trxDebet($dari, $sampai, $kodebaku);
        foreach ($trxdbt as $trx1) {
            $tglbukti   = $trx1['tgl_invoice'];
            $nobukti    = $trx1['no_invoice'];
            $rectype    = '1';
            $keterangan = 'PEMBELIAN D/ ' . $trx1['nama_supplier'];
            $baku       = $trx1['kode_baku'];
            $nilai      = $trx1['qty'];
            $raw2 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_baku'     => $baku,
                'stockin'       => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk04->insertKartuStock($raw2);
        }

        $trxdbt2 = $this->ModelLapStk04->trxDebet2($dari, $sampai, $kodebaku);
        foreach ($trxdbt2 as $trx3) {
            $tglbukti   = $trx3['tgl_adjustment'];
            $nobukti    = $trx3['no_adjustment'];
            $rectype    = '1';
            $keterangan = 'STOCK ADJUSTMENT';
            $baku       = $trx3['kode_baku'];
            $nilai      = $trx3['qty'];
            $raw4 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_baku'     => $baku,
                'stockin'       => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk04->insertKartuStock($raw4);
        }


        $trxcrd = $this->ModelLapStk04->trxCredit($dari, $sampai, $kodebaku);
        foreach ($trxcrd as $trx4) {
            $tglbukti  = $trx4['tgl_bukti'];
            $nobukti   = $trx4['no_bukti'];
            $rectype   = '2';
            $keterangan = 'PEMAKAIAN BAHAN BAKU';
            $baku     = $trx4['kode_baku'];
            $nilai      = $trx4['qty'];
            $raw5 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_baku'     => $baku,
                'stockout'      => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk04->insertKartuStock($raw5);
        }

        $trxcrd2 = $this->ModelLapStk04->trxCredit2($dari, $sampai, $kodebaku);
        foreach ($trxcrd2 as $trx5) {
            $tglbukti   = $trx5['tgl_adjustment'];
            $nobukti    = $trx5['no_adjustment'];
            $rectype    = '2';
            $keterangan = 'STOCK ADJUSTMENT';
            $baku       = $trx5['kode_baku'];
            $nilai      = $trx5['qty'] * -1;
            $raw6 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_baku'     => $baku,
                'stockout'      => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk04->insertKartuStock($raw6);
        }

        $trxcrd3 = $this->ModelLapStk04->trxCredit3($dari, $sampai, $kodebaku);
        foreach ($trxcrd3 as $trx6) {
            $tglbukti   = $trx6['tgl_retur'];
            $nobukti    = $trx6['no_retur'];
            $rectype    = '2';
            $keterangan = 'RETUR PEMBELIAN';
            $baku       = $trx6['kode_baku'];
            $nilai      = $trx6['qty'];
            $raw6 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_baku'     => $baku,
                'stockout'      => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk04->insertKartuStock($raw6);
        }

        $trxcrd4 = $this->ModelLapStk04->trxCredit4($dari, $sampai, $kodebaku);
        foreach ($trxcrd4 as $trx4) {
            $tglbukti  = $trx4['tgl_bukti'];
            $nobukti   = $trx4['no_bukti'];
            $rectype   = '2';
            $keterangan = 'PEMAKAIAN BAHAN BAKU';
            $baku     = $trx4['kode_baku'];
            $nilai      = $trx4['qty'];
            $raw5 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_baku'     => $baku,
                'stockout'      => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk04->insertKartuStock($raw5);
        }


        $laporan = $this->ModelLapStk04->getKartuStock();

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('LapStk04/tampil', $data);
        }

        if (isset($tombolExport)) {
            // HEADER
            $title1 = session()->get('nama_company');

            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Source Sans Pro');
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
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'TANGGAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO BUKTI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'KETERANGAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'MASUK');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'KELUAR');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'SALDO');

            $kolom = 6;
            $nomor = 1;
            $totawl = 0;
            $totdbt = 0;
            $totcrd = 0;
            $saldo  = 0;

            $kdmerk = '';
            $sw = 0;

            // DETAIL
            foreach ($laporan as $lap) {
                if ($lap['kode_baku'] != $kdmerk) {
                    if ($sw == 1) {
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                        $kolom = $kolom + 1;
                        $totdbt = 0;
                        $totcrd = 0;
                    }
                    $kolom = $kolom + 1;
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_baku']);
                    $kdmerk = $lap['kode_baku'];
                    $saldo = $lap['balance'];
                    $kolom = $kolom + 1;
                }

                $sw = 1;
                $totdbt = $totdbt + $lap['stockin'];
                $totcrd = $totcrd + $lap['stockout'];
                $saldo  = $saldo + $lap['stockin'] - $lap['stockout'];

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-m-Y', strtotime($lap['tgl_bukti'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['no_bukti']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['keterangan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['stockin']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['stockout']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $saldo);
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $nomor++;
                $kolom = $kolom + 1;
            }

            if ($sw == 1) {
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;
                $nomor = 1;
            }


            $writer = new Xlsx($spreadsheet);
            $filename = 'LapStk04' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
