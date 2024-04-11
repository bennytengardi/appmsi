<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelPurchInv;
use App\Models\ModelBarang;
use App\Models\ModelLapBeli01;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapBeli01 extends BaseController
{
    function __construct()
    {
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapBeli01 = new ModelLapBeli01();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Pembelian',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapbeli01/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $status    = $this->request->getPost('status');
        $typelap   = $this->request->getPost('typelap');
        $title = "LAPORAN PEMBELIAN";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapBeli01->lapbeli01($dari, $sampai, $status, $typelap);


        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'laporan' => $laporan,
                'status' => $status
            );
            if ($typelap == 'REKAP') {
                return view('lapbeli01/tampil', $data);
            } else {
                
                return view('lapbeli01/tampildetail', $data);
            }
        }

        if (isset($tombolExport)) {

            if ($typelap == 'REKAP') {

                // HEADER
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


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'INVOICE SUPP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'NAMA SUPPLIER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'TOTAL INVOICE');


                $kolom = 6;
                $nomor = 1;
                $t05 = 0;

                // DETAIL

                foreach ($laporan as $sttb) {
                    $t05 += $sttb['total_invoice'];

                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $nomor);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_invoice']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($sttb['tgl_invoice'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $sttb['invoice_supp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['nama_supplier']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['total_invoice']);
                    $kolom++;
                    $nomor++;
                }

                // FOOTER TOTAL


                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $t05);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapbeli01' .  '.xlsx';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename = ' . $filename . '');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit;
            } else {
                // HEADER
                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:H3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:H5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:H5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:H5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'INVOICE SUPPL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NAMA SUPPLIER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'NAMA BARANG');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'QTY');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'HARGA');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'TOTAL');


                $kolom = 6;
                $nomor = 1;
                $totinv = 0;
                $gtotinv = 0;
                $sw = 0;
                $tgl = '';
                $noinv = '';

                // DETAIL
                foreach ($laporan as $lap) {
                    if ($lap['no_invoice'] != $noinv) {
                        if ($sw == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'TOTAL INVOICE');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totinv);
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);

                            $kolom = $kolom + 2;
                            $totinv = 0;
                        }
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_invoice']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['invoice_supp']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_supplier']);
                        $noinv = $lap['no_invoice'];
                    }

                    $totinv = $totinv + $lap['subtotal'];
                    $gtotinv = $gtotinv + $lap['subtotal'];

                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['nama_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['qty']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['harga']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $lap['subtotal']);
                    $noinv = $lap['no_invoice'];
                    $sw = 1;
                    $kolom = $kolom + 1;
                    $nomor++;
                }

                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'TOTAL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totinv);
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);

                $kolom = $kolom + 2;
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'GRAND TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $gtotinv);
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);


                $writer = new Xlsx($spreadsheet);
                $filename = 'lapbeli01d' .  '.xlsx';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename = ' . $filename . '');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit;
            }
        }
    }
}
