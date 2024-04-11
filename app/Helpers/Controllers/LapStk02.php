<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelMerk;
use App\Models\ModelLapStk02;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapStk02 extends BaseController
{
    function __construct()
    {
        $this->ModelBarang = new ModelBarang();
        $this->ModelMerk = new ModelMerk();
        $this->ModelLapStk02 = new ModelLapStk02();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Kartu Stok',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'merk' => $this->ModelMerk->allData(),
            'barang' => $this->ModelBarang->alldata(),
        ];
        return view('lapstk02/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kode_merk    = $this->request->getPost('kode_merk');
        $kodebarang  = $this->request->getPost('kode_barang');

        $title = "LAPORAN KARTU STOCK";
        $barang = $this->ModelBarang->allData();
        foreach ($barang as $bak) {
            $data = [
                'id_barang' => $bak['id_barang'],
                'kode_barang' => $bak['kode_barang'],
                'awldbt' => 0,
                'awldbt2' => 0,
                'awldbt3' => 0,
                'awlcrd' => 0,
                'awlcrd2' => 0,
                'crd'  => 0,
                'crd2' => 0,
                'dbt'  => 0,
                'dbt2' => 0,
                'dbt3' => 0,
            ];
            $this->ModelBarang->clearSaldo($data);
        }

        $awldbt = $this->ModelLapStk02->awalDebet($dari, $kodebarang);
        foreach ($awldbt as $aw1) {
            $barang = $aw1['kode_barang'];
            $nilai = $aw1['awldbt'];
            $raw1 = [
                'kode_barang' => $barang,
                'awldbt' => $nilai
            ];
            $this->ModelLapStk02->updateSaldoAwal($raw1);
        }


        $awldbt3 = $this->ModelLapStk02->awalDebet3($dari, $kodebarang);
        foreach ($awldbt3 as $aw1) {
            $barang = $aw1['kode_barang'];
            $nilai = $aw1['awldbt3'];
            $raw1 = [
                'kode_barang' => $barang,
                'awldbt3' => $nilai
            ];
            $this->ModelLapStk02->updateSaldoAwal($raw1);
        }

        $awlcrd = $this->ModelLapStk02->awalCredit($dari, $kodebarang);
        foreach ($awlcrd as $aw2) {
            $barang = $aw2['kode_barang'];
            $nilai = $aw2['awlcrd'];
            $raw1 = [
                'kode_barang' => $barang,
                'awlcrd' => $nilai
            ];
            $this->ModelLapStk02->updateSaldoAwal($raw1);
        }

        $awlcrd2 = $this->ModelLapStk02->awalCredit2($dari, $kodebarang);
        foreach ($awlcrd2 as $aw2) {
            $barang = $aw2['kode_barang'];
            $nilai = $aw2['awlcrd2'];
            $raw1 = [
                'kode_barang' => $barang,
                'awlcrd2' => $nilai * -1
            ];
            $this->ModelLapStk02->updateSaldoAwal($raw1);
        }



        $this->ModelLapStk02->clearKartuStock();
        if ($kodebarang == "ALL") {
            $dbarang = $this->ModelBarang->allData();
        } else {
            $dbarang = $this->ModelBarang->getBarang($kodebarang);
        }



        foreach ($dbarang as $aw3) {
            $tglbukti  = date('Y-m-d', strtotime('-1 days', strtotime($dari)));
            $nobukti   = '';
            $rectype   = '1';
            $barang      = $aw3['kode_barang'];
            $nilai     =  $aw3['awal'] + $aw3['awldbt'] + $aw3['awldbt2'] + $aw3['awldbt3'] - $aw3['awlcrd'] - $aw3['awlcrd2'];
            $raw1 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => 'Saldo Awal',
                'kode_barang'   => $barang,
                'balance'       => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk02->insertKartuStock($raw1);
        }

        $trxdbt = $this->ModelLapStk02->trxDebet($dari, $sampai, $kodebarang);
        foreach ($trxdbt as $trx1) {
            $tglbukti   = $trx1['tgl_bukti'];
            $nobukti    = $trx1['no_bukti'];
            $rectype    = '1';
            $keterangan = 'PEMBELIAN';
            $barang     = $trx1['kode_barang'];
            $nilai      = $trx1['qty'];
            $raw2 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_barang'    => $barang,
                'stockin'       => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk02->insertKartuStock($raw2);
        }

        $trxdbt3 = $this->ModelLapStk02->trxDebet3($dari, $sampai, $kodebarang);
        foreach ($trxdbt3 as $trx3) {
            $tglbukti   = $trx3['tgl_adjustment'];
            $nobukti    = $trx3['no_adjustment'];
            $rectype    = '1';
            $keterangan = $trx3['keterangan'];
            $barang       = $trx3['kode_barang'];
            $nilai      = $trx3['qty'];
            $raw4 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_barang'   => $barang,
                'stockin'       => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk02->insertKartuStock($raw4);
        }


        $trxcrd = $this->ModelLapStk02->trxCredit($dari, $sampai, $kodebarang);
        foreach ($trxcrd as $trx4) {
            $tglbukti  = $trx4['tgl_suratjln'];
            $nobukti   = $trx4['no_suratjln'];
            $rectype   = '2';
            $keterangan = 'PENJUALAN KE ' . $trx4['nama_customer'];
            $barang     = $trx4['kode_barang'];
            $nilai      = $trx4['qty'];
            $raw5 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_barang'   => $barang,
                'stockout'      => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk02->insertKartuStock($raw5);
        }

        $trxcrd2 = $this->ModelLapStk02->trxCredit2($dari, $sampai, $kodebarang);
        foreach ($trxcrd2 as $trx5) {
            $tglbukti   = $trx5['tgl_adjustment'];
            $nobukti    = $trx5['no_adjustment'];
            $rectype    = '2';
            $keterangan = $trx5['keterangan'];
            $barang       = $trx5['kode_barang'];
            $nilai      = $trx5['qty'] * -1;
            $raw6 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_barang'   => $barang,
                'stockout'      => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapStk02->insertKartuStock($raw6);
        }

        $laporan = $this->ModelLapStk02->getKartuStock($kode_merk);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapstk02/tampil', $data);
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
                if ($lap['kode_barang'] != $kdmerk) {
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
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_barang']);
                    $kdmerk = $lap['kode_barang'];
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
            $filename = 'LapStk02' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
