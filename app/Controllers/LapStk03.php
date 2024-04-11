<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelMerk;
use App\Models\ModelLapStk03;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapStk03 extends BaseController
{
    function __construct()
    {
        $this->ModelBarang = new ModelBarang();
        $this->ModelLapStk03 = new ModelLapStk03();
        $this->ModelMerk = new ModelMerk();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Stok Barang Jadi',
            'merk'   => $this->ModelMerk->allData(),
        ];
        return view('lapstk03/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $kode_merk    = $this->request->getPost('kode_merk');

        // $dari      = $this->request->getPost('dari');
        // $sampai    = $this->request->getPost('sampai');

        $title = "LAPORAN STOCK BARANG";
        $laporan = $this->ModelBarang->getAllData($kode_merk);
        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'tgl'   => date("d-m-Y"),
                'kode_merk'    => $kode_merk,
                'laporan' => $laporan,
            );
            return view('lapstk03/tampil', $data);
        }

        if (isset($tombolExport)) {
            // HEADER
            $title1 = session()->get('nama_company');
            $tgl   = date("d-m-Y");
            

            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Source Sans Pro');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:D1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:D2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:D3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', $tgl);

            $spreadsheet->getActiveSheet()->getStyle('A5:D5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(70);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(8);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'KODE BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NAMA BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'SATUAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'STOCK');

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
                    $kolom = $kolom + 1;
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['kode_merk']);
                    $kdmerk = $lap['kode_merk'];
                }

                $sw = 1;

                $stock = $lap['awal'] + $lap['masuk'] + $lap['returjual'] - $lap['keluar'] - $lap['returbeli'] + $lap['adjust'];

                if ($stock != 0) {
                $kolom = $kolom + 1;
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, ' ' . $lap['kode_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['nama_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['kode_satuan']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $stock);
                    $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $nomor++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapstk03' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
