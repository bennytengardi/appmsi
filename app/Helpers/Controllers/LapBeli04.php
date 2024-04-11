<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelPurchInv;
use App\Models\ModelBaku;
use App\Models\ModelLapBeli04;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapBeli04 extends BaseController
{
    function __construct()
    {
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelBaku   = new ModelBaku();
        $this->ModelLapBeli04 = new ModelLapBeli04();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Pembelian',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'supplier' => $this->ModelSupplier->allData2(),
        ];
        return view('lapbeli04/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodesupp  = $this->request->getPost('kode_supplier');

        $title = "LAPORAN PEMBELIAN";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapBeli04->lapbeli04($dari, $sampai, $kodesupp);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapbeli04/tampil', $data);
        }

        if (isset($tombolExport)) {

            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
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
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:D5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(14);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'KODE BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NAMA BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TOTAL QTY');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'TOTAL RP');

            $kolom = 6;
            $tqty = 0;
            $tamt = 0;
            $gtqty = 0;
            $gtamt = 0;
            $kdsupp = '';
            $sw = 0;
            foreach ($laporan as $lap) {
                if ($kdsupp <> $lap['kode_supplier']) {
                    if ($sw == 1) {
                        // $kolom = $kolom + 1;
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $tqty);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tamt);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);

                        $kolom = $kolom + 1;
                        $nomor = 1;
                        $tqty = 0;
                        $tamt = 0;
                    }
                    $kolom = $kolom + 1;
                    $supplier = $this->ModelSupplier->detail($lap['kode_supplier']);
                    $det = $supplier['nama_supplier'];
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kdsupp = $lap['kode_supplier'];
                    $kolom = $kolom + 1;
                    $sw = 1;
                }

                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $tqty += $lap['totqty'];
                $tamt += $lap['totrp'];
                $gtqty += $lap['totqty'];
                $gtamt += $lap['totrp'];

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['kode_baku']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['nama_baku']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['totqty']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['totrp']);
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $tqty);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tamt);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);


            $kolom = $kolom + 2;
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $gtqty);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $gtamt);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapbeli04' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
