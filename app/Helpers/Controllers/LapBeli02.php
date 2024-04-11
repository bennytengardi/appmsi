<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelPurchInv;
use App\Models\ModelBarang;
use App\Models\ModelLapBeli02;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapBeli02 extends BaseController
{
    function __construct()
    {
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapBeli02 = new ModelLapBeli02();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Pembelian',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'supplier' => $this->ModelSupplier->allData2(),
        ];
        return view('lapbeli02/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodesupp  = $this->request->getPost('kode_supplier');
        $status    = $this->request->getPost('status');
        $typelap   = $this->request->getPost('typelap');
        $title = "LAPORAN PEMBELIAN";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapBeli02->lapbeli02($dari, $sampai, $kodesupp, $typelap);


        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'laporan' => $laporan,
                'status' => $status
            );
            if ($typelap == 'REKAP') {
                return view('lapbeli02/tampil', $data);
            } else {
                return view('lapbeli02/tampildetail', $data);
            }
        }

        if (isset($tombolExport)) {
            if ($typelap == 'REKAP') {

                // HEADER
                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:E1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:E2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:E3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:E5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:E5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:E5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:E5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'INVOICE SUPP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'TOTAL INVOICE');


                $kolom = 6;
                $nomor = 1;
                $stotal = 0;
                $gtotal = 0;
                $sw = 0;
                $kdsupp = '';
                // DETAIL

                foreach ($laporan as $sttb) {
                    if ($kdsupp <> $sttb['kode_supplier']) {
                        if ($sw == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $stotal);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

                            $kolom = $kolom + 1;
                            $nomor = 1;
                            $stotal = 0;
                        }
                        $kolom = $kolom + 1;
                        $supplier = $this->ModelSupplier->detail($sttb['kode_supplier']);
                        $det = $supplier['nama_supplier'];
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $kdsupp = $sttb['kode_supplier'];
                        $kolom = $kolom + 1;
                    }

                    $sw = 1;
                    $stotal += $sttb['total_invoice'];
                    $gtotal += $sttb['total_invoice'];

                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $nomor);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_invoice']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($sttb['tgl_invoice'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $sttb['invoice_supp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['total_invoice']);
                    $kolom++;
                    $nomor++;
                }

                if ($sw == 1) {
                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $stotal);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                    $kolom = $kolom + 1;
                    $nomor = 1;
                }

                // FOOTER TOTAL

                $kolom = $kolom + 2;

                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $gtotal);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapbeli02' .  '.xlsx';
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
                $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:G3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(14);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'NO NOTA');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NAMA BARANG');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'QTY');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'HARGA');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'TOTAL');

                $kolom = 6;
                $nomor = 1;
                $totinv = 0;
                $gtotinv = 0;
                $ftotinv = 0;
                $tgl = '';
                $noinv = '';
                $kdsupp = '';
                $sw = 0;
                $sw2 = 0;

                // DETAIL
                foreach ($laporan as $lap) {

                    if ($noinv != $lap['no_invoice']) {
                        if ($sw2 == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                            $spreadsheet->getActiveSheet()->mergeCells('E' . $kolom . ':' . 'F' . $kolom);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL INVOICE');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $ftotinv);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            $nomor = 1;
                            $ftotinv = 0;
                        }
                    }
                    if ($kdsupp <> $lap['kode_supplier']) {
                        if ($sw == 1) {
                            $kolom = $kolom + 1;
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL SUPPLIER ');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $totinv);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 2;
                            $nomor = 1;
                            $totinv = 0;
                        }

                        $supplier = $this->ModelSupplier->detail($lap['kode_supplier']);
                        $det = $supplier['nama_supplier'];

                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'G' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $kdsupp = $lap['kode_supplier'];
                    }

                    $sw = 1;
                    $sw2 = 1;
                    $totinv  = $totinv  + $lap['subtotal'];
                    $ftotinv = $ftotinv + $lap['subtotal'];
                    $gtotinv = $gtotinv + $lap['subtotal'];
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    if ($lap['no_invoice'] != $noinv) {
                        $kolom = $kolom + 1;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_invoice']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['invoice_supp']);
                        $noinv = $lap['no_invoice'];
                    }

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['qty']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['harga']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['subtotal']);
                    $kolom++;
                    $nomor++;
                }


                // FOOTER TOTAL
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                $spreadsheet->getActiveSheet()->mergeCells('E' . $kolom . ':' . 'F' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $ftotinv);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

                $kolom = $kolom + 2;
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL SUPPLIER ');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $totinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);


                $kolom = $kolom + 2;
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'GRAND TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $gtotinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapbeli02d' .  '.xlsx';
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
