<?php

namespace App\Controllers;

use App\Models\ModelSalesman;
use App\Models\ModelSalesInv;
use App\Models\ModelBarang;
use App\Models\ModelLapJual09;
use App\Models\ModelDivisi;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual09 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelSalesman = new ModelSalesman();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual09 = new ModelLapJual09();
        $this->ModelDivisi = new ModelDivisi();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Penjualan',
            'divisi' => $this->ModelDivisi->allData(),            
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'salesman' => $this->ModelSalesman->alldata(),
        ];
        return view('lapjual09/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $typelap   = $this->request->getPost('typelap');
        $kodesales = $this->request->getPost('kode_salesman');
        $kodedivisi= $this->request->getPost('kode_divisi');
        $title     = "LAPORAN PENJUALAN";
        $title1    = session()->get('nama_company');
        $laporan = $this->ModelLapJual09->lapjual09($dari, $sampai, $kodesales, $kodedivisi, $typelap);


        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'laporan' => $laporan,
            );

            if ($typelap == 'REKAP') {
                return view('lapjual09/tampil', $data);
            } else {
                return view('lapjual09/tampildetail', $data);
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


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NAMA CUSTOMER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NO PO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'TOTAL INVOICE');

                $kolom = 6;
                $totinv = 0;
                $totinv2 = 0;
                $gtotinv = 0;
                $sw = 0;
                $sw2 = 0;
                $kdcust = '';
                $kdsales = '';
                // DETAIL

                foreach ($laporan as $lap) {
                    if ($kdcust <> $lap['kode_customer']) {
                        if ($sw2 == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL CUSTOMER');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totinv2);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 2;
                            $totinv2 = 0;
                        }
                    }

                    if ($kdsales <> $lap['kode_salesman']) {
                        if ($sw == 1) {
                            $kolom = $kolom + 1;
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL SALESMAN');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totinv);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                            $totinv = 0;
                            $kolom = $kolom + 2;
                        }
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(16);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_salesman']);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $kolom = $kolom + 2;
                    }

                    $blank = '';
                    $sw = 1;
                    $sw2 = 1;
                    $totinv  += $lap['total_invoice'];
                    $totinv2 += $lap['total_invoice'];
                    $gtotinv += $lap['total_invoice'];

                    if ($lap['kode_customer'] != $kdcust) {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_customer']);
                    } else {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $blank);
                    }

                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['no_invoice']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['no_po']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['total_invoice']);
                    $kdsales = $lap['kode_salesman'];
                    $kdcust  = $lap['kode_customer'];
                    $kolom = $kolom + 1;
                }


                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totinv2);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 2;

                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL SALESMAN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 2;

                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);

                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(12);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setSize(12);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'GRAND TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $gtotinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual09' .  '.xlsx';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename = ' . $filename . '');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit;
            } else {
                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:K1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:K2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:K3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', '');

                $spreadsheet->getActiveSheet()->getStyle('A5:K5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:K5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:K5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:I5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(8);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(14);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'No Invoice');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'Tgl Invoice');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'No PO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'Nama Customer');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'Nama Barang');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'Qty');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'Satuan');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'Harga');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'SubTotal');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J5', 'DownPayment');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K5', 'Total');

                $totinv = 0;
                $stotinv = 0;
                $stotdp = 0;
                $gtotinv = 0;
                $totdp = 0;

                $kolom = 6;
                $nomor = 1;
                $sw = 0;
                $tgl = '';
                $noinv = '';
                $kdcust = '';

                // DETAIL
                foreach ($laporan as $lap) {
                    
                    if ($lap['no_invoice'] != $noinv) {
                        if ($sw == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL INVOICE');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $stotinv);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $stotdp);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $kolom, $stotinv - $stotdp );
                            
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getFont()->setBold(true);
                            $totdp = $totdp + $stotdp;
                            $kolom = $kolom + 2;
                            $stotinv = 0;
                            $stotdp = 0;
                        }
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_invoice']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['no_po']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_customer']);
                        $noinv = $lap['no_invoice'];
                    }
                    $totinv = $totinv + $lap['subtotal'];
                    $stotinv = $stotinv + $lap['subtotal'];
                    $gtotinv = $gtotinv + $lap['subtotal'];
                    $stotdp = $lap['total_dp']; 
                    $sw = 1;


                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['nama_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['qty']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['kode_satuan']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $lap['harga']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $lap['subtotal']);
                   
                    $noinv = $lap['no_invoice'];
                    $sw = 1;
                    $kolom = $kolom + 1;
                    $nomor++;
                }

                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $stotinv);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $stotdp);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $kolom, $stotinv - $stotdp);

                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getFont()->setBold(true);

                $kolom = $kolom + 2;
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL PER SALESMAN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totinv);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $totdp);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $kolom, $totinv - $totdp);

                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getFont()->setBold(true);


                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual09d' .  '.xlsx';
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
