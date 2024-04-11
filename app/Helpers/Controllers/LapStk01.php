<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelSalesInv;
use App\Models\ModelAdjustment;
use App\Models\ModelLapStk01;
use App\Models\ModelMerk;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapStk01 extends BaseController
{
    function __construct()
    {
        $this->ModelBarang = new ModelBarang();
        $this->ModelMerk = new ModelMerk();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelAdjustment = new ModelAdjustment();
        $this->ModelLapStk01 = new ModelLapStk01();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Stok Barang Jadi',
            'merk'   => $this->ModelMerk->allData(),
            'dari'   => date("Y-01-02"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapstk01/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kode_merk  = $this->request->getPost('kode_merk');

        $title = "LAPORAN STOCK BARANG JADI";
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

        $awldbt = $this->ModelLapStk01->awalDebet($dari);
        foreach ($awldbt as $aw1) {
            $barang = $aw1['kode_barang'];
            $nilai = $aw1['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'awldbt' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }

        $awldbt3 = $this->ModelLapStk01->awalDebet3($dari);
        foreach ($awldbt3 as $aw1) {
            $barang = $aw1['kode_barang'];
            $nilai = $aw1['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'awldbt3' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }

        $awlcrd = $this->ModelLapStk01->awalCredit($dari);
        foreach ($awlcrd as $aw2) {
            $barang = $aw2['kode_barang'];
            $nilai = $aw2['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'awlcrd' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }

        $awlcrd2 = $this->ModelLapStk01->awalCredit2($dari);
        foreach ($awlcrd2 as $aw2) {
            $barang = $aw2['kode_barang'];
            $nilai = $aw2['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'awlcrd2' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }


        $trxdbt = $this->ModelLapStk01->trxDebet($dari, $sampai);
        foreach ($trxdbt as $trx1) {
            $barang  = $trx1['kode_barang'];
            $nilai = $trx1['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'dbt' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }

        $trxdbt3 = $this->ModelLapStk01->trxDebet3($dari, $sampai);
        foreach ($trxdbt3 as $trx1) {
            $barang  = $trx1['kode_barang'];
            $nilai = $trx1['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'dbt3' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }

        $trxcrd = $this->ModelLapStk01->trxCredit($dari, $sampai);
        foreach ($trxcrd as $trx2) {
            $barang  = $trx2['kode_barang'];
            $nilai = $trx2['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'crd' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }

        $trxcrd2 = $this->ModelLapStk01->trxCredit2($dari, $sampai);
        foreach ($trxcrd2 as $trx2) {
            $barang  = $trx2['kode_barang'];
            $nilai = $trx2['awl'];
            $raw1 = [
                'kode_barang' => $barang,
                'crd2' => $nilai
            ];
            $this->ModelLapStk01->updateSaldoAwal($raw1);
        }


        $laporan = $this->ModelLapStk01->getSaldoStok($kode_merk);
        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapstk01/tampil', $data);
        }

        if (isset($tombolExport)) {
            // HEADER
            $title1 = session()->get('nama_company');

            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Source Sans Pro');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:I3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:I5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:I5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:I5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:I5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'KODE BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NAMA BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'SALDO AWAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'HASIL PROD');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'BELI LUAR');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'ADJUST(+)');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'SRT JALAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'ADJUST(-)');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'SALDO AKHIR');

            $kolom = 6;
            $nomor = 1;
            $totawl = 0;
            $totdbt = 0;
            $totcrd = 0;
            $totakh = 0;

            $kdmerk = '';
            $sw = 0;

            // DETAIL
            foreach ($laporan as $lap) {
                if ($lap['kode_merk'] != $kdmerk) {
                    if ($sw == 1) {
                        $kolom = $kolom + 1;
                    }
                    $kolom = $kolom + 1;
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_merk']);
                    $kdmerk = $lap['kode_merk'];
                }

                $sw = 1;

                $kolom = $kolom + 1;

                $totawl = $lap['awal'] + $lap['awldbt'] + $lap['awldbt2'] + $lap['awldbt3'] - $lap['awlcrd'] - $lap['awlcrd2'];
                $totdbt = $lap['dbt'] + $lap['dbt2'] + $lap['dbt3'];
                $totcrd = $lap['crd'] + $lap['crd2'];
                $totakh = $totawl + $totdbt - $totcrd;



                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, ' ' . $lap['kode_barang']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['nama_barang']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $totawl);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['dbt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['dbt2']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['dbt3']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['crd']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $lap['crd2']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totakh);
                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $nomor++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapstk01' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
