<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelBarang;
use App\Models\ModelLapJual02;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual02 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual02 = new ModelLapJual02();
    }

    public function index()
    {
        $data = [
            'title'  => 'Sales By Customer',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
            'customer' => $this->ModelCustomer->alldata2(),
        ];
        return view('lapjual02/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $typelap   = $this->request->getPost('typelap');
        $kodecust  = $this->request->getPost('kode_customer');
        $title1 = session()->get('nama_company');
        $title = "Sales By Customer";

        $laporan = $this->ModelLapJual02->lapjual02($dari, $sampai, $kodecust, $typelap);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'laporan' => $laporan,
            );
            if ($typelap == 'REKAP') {
                return view('lapjual02/tampil', $data);
            } else {
                return view('lapjual02/tampildetail', $data);
            }
        }

        if (isset($tombolExport)) {
            if ($typelap == 'REKAP') {

                // HEADER
                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:J1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:J2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:J3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:J5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(18);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NO DO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'TOTAL AMOUNT');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'TOTAL DISC');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'TOTAL DP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'TOTAL DPP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'TOTAL PPN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J5', 'TOTAL INVOICE');


                $kolom = 6;
                $nomor = 1;
                $s01 = 0;
                $s02 = 0;
                $s03 = 0;
                $s04 = 0;
                $s05 = 0;
                $s06 = 0;
                $t01 = 0;
                $t02 = 0;
                $t03 = 0;
                $t04 = 0;
                $t05 = 0;
                $t06 = 0;
                $sw = 0;
                $kdcust = '';
                // DETAIL

                foreach ($laporan as $sttb) {
                    if ($kdcust <> $sttb['kode_customer']) {
                        if ($sw == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $s01);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $s02);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $s03);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $s04);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $s05);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $s06);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);

                            $kolom = $kolom + 1;
                            $nomor = 1;
                            $s01 = 0;
                            $s02 = 0;
                            $s03 = 0;
                            $s04 = 0;
                            $s05 = 0;
                            $s06 = 0;
                        }
                        $kolom = $kolom + 1;
                        $customer = $this->ModelCustomer->detail($sttb['kode_customer']);
                        $det = $customer['nama_customer'];
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'J' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $kdcust = $sttb['kode_customer'];
                        $kolom = $kolom + 1;
                    }

                    $sw = 1;
                    $s01 += $sttb['total_amount'];
                    $s02 += $sttb['total_discount'];
                    $s03 += $sttb['total_dp'];
                    $s04 += $sttb['total_dpp'];
                    $s05 += $sttb['total_ppn'];
                    $s06 += $sttb['total_invoice'];
                    $t01 += $sttb['total_amount'];
                    $t02 += $sttb['total_discount'];
                    $t03 += $sttb['total_dp'];
                    $t04 += $sttb['total_dpp'];
                    $t05 += $sttb['total_ppn'];
                    $t06 += $sttb['total_invoice'];

                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $nomor);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_invoice']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($sttb['tgl_invoice'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $sttb['no_suratjln']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['total_amount']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['total_discount']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $sttb['total_dp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $sttb['total_dpp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $sttb['total_ppn']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $sttb['total_invoice']);
                    $kolom++;
                    $nomor++;
                }

                if ($sw == 1) {
                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $s01);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $s02);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $s03);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $s04);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $s05);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $s06);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);
                    $kolom = $kolom + 1;
                    $nomor = 1;
                }

                // FOOTER TOTAL

                $kolom = $kolom + 2;

                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $t01);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $t02);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $t03);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $t04);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $t05);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $t06);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual02' .  '.xlsx';
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
                $spreadsheet->getActiveSheet()->mergeCells('A1:J1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:J2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:J3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:J5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(8);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(14);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'NO DO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NAMA BARANG');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'QTY');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'SATUAN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'HARGA');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'SUBTOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'PPN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J5', 'TOTAL');

                $kolom = 6;
                $nomor = 1;
                $totamt = 0;
                $gtotamt = 0;
                $ftotamt = 0;
                $totppn= 0;
                $gtotppn = 0;
                $ftotppn = 0;
                $totinv = 0;
                $gtotinv = 0;
                $ftotinv = 0;
                $tgl = '';
                $noinv = '';
                $kdcust = '';
                $sw = 0;
                $sw2 = 0;

                // DETAIL
                foreach ($laporan as $lap) {

                    if ($noinv != $lap['no_invoice']) {
                        if ($sw2 == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'G' . $kolom);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);

                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL INVOICE');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $ftotamt);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $ftotppn);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $ftotinv);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            $nomor = 1;
                            $ftotinv = 0;
                        }
                    }
                    if ($kdcust <> $lap['kode_customer']) {
                        if ($sw == 1) {
                            $kolom = $kolom + 1;
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'G' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL CUSTOMER ');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totamt);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totppn);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $totinv);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 2;
                            $nomor = 1;
                            $totinv = 0;
                        }

                        $customer = $this->ModelCustomer->detail($lap['kode_customer']);
                        $det = $customer['nama_customer'];

                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'J' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $kdcust = $lap['kode_customer'];
                    }

                    $sw = 1;
                    $sw2 = 1;
                    $totamt  = $totamt  + $lap['subtotal'];
                    $ftotamt = $ftotamt + $lap['subtotal'];
                    $gtotamt = $gtotamt + $lap['subtotal'];
                    $totppn  = $totppn  + $lap['subtotal'] * 0.11;
                    $ftotppn = $ftotppn + $lap['subtotal'] * 0.11;
                    $gtotppn = $gtotppn + $lap['subtotal'] * 0.11;
                    $totinv  = $totinv  + $lap['subtotal'] * 1.11;
                    $ftotinv = $ftotinv + $lap['subtotal'] * 1.11;
                    $gtotinv = $gtotinv + $lap['subtotal'] * 1.11;



                    if ($lap['no_invoice'] != $noinv) {
                        $kolom = $kolom + 1;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_invoice']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['no_suratjln']);
                        $noinv = $lap['no_invoice'];
                    }
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['qty']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['kode_satuan']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['harga']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $lap['subtotal']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $lap['subtotal'] * 0.11);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $lap['subtotal'] * 1.11);
                    $kolom++;
                    $nomor++;
                }

                // FOOTER TOTAL
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'G' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $ftotamt);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $ftotppn);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $ftotinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);

                $kolom = $kolom + 2;
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'G' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL CUSTOMER ');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totamt);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totppn);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $totinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);


                $kolom = $kolom + 2;
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'G' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'GRAND TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $gtotamt);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $gtotppn);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $gtotinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getFont()->setBold(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual02d' .  '.xlsx';
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
