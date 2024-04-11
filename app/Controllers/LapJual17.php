<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelBarang;
use App\Models\ModelDivisi;
use App\Models\ModelLapJual17;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual17 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelDivisi = new ModelDivisi();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual17 = new ModelLapJual17();
    }

    public function index()
    {
        $data = [
            'title' => 'Sales By Division',
            'divisi' => $this->ModelDivisi->allData(),
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapjual17/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodedivisi  = $this->request->getPost('kode_divisi');
        $typelap   = $this->request->getPost('typelap');
        $title = "Sales By Division";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual17->lapjual17($dari, $sampai,$kodedivisi, $typelap);


        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'divisi'  => $kodedivisi,
                'laporan' => $laporan,
            );
            if ($typelap == 'REKAP') {
                return view('lapjual17/tampil', $data);
            } else {
                return view('lapjual17/tampildetail', $data);
            }
        }

        if (isset($tombolExport)) {

            if ($typelap == 'REKAP') {

                // HEADER
                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:L2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:L3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:L5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:L5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:L5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:L5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $kodedivisi);

                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(18);


                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NO DO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'NAMA CUSTOMER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'TOTAL AMOUNT');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'TOTAL DISC');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'TOTAL DP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'TOTAL DPP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J5', 'TOTAL PPN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K5', 'ONGKOS KIRIM');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('L5', 'TOTAL INVOICE');


                $kolom = 6;
                $nomor = 1;
                $t01 = 0;
                $t02 = 0;
                $t03 = 0;
                $t04 = 0;
                $t05 = 0;
                $t06 = 0;
                $t07 = 0;

                // DETAIL

                foreach ($laporan as $sttb) {
                    $t01 += $sttb['total_amount'];
                    $t02 += $sttb['total_discount'];
                    $t03 += $sttb['total_dp'];
                    $t04 += $sttb['total_dpp'];
                    $t05 += $sttb['total_ppn'];
                    $t06 += $sttb['ongkir'];
                    $t07 += $sttb['total_invoice'];

                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $nomor);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_invoice']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($sttb['tgl_invoice'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $sttb['no_suratjln']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['nama_customer']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['total_amount']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $sttb['total_discount']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $sttb['total_dp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $sttb['total_dpp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $sttb['total_ppn']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $kolom, $sttb['ongkir']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $kolom, $sttb['total_invoice']);
                    $kolom++;
                    $nomor++;
                }

                // FOOTER TOTAL


                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('K' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('L' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $t01);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $t02);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $t03);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $t04);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $t05);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $kolom, $t06);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $kolom, $t07);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual17' .  '.xlsx';
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
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $kodedivisi);

                $spreadsheet->getActiveSheet()->getStyle('A5:I5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:I5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:I5')
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
               

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'NO PO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NAMA CUSTOMER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'NAMA BARANG');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'QTY');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'SATUAN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'HARGA');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'SUB TOTAL');
                
                $kolom = 6;
                $nomor = 1;
                $totamt = 0;
                $gtotamt = 0;
                $totppn = 0;
                $gtotppn = 0;
                $totinv = 0;
                $gtotinv = 0;
                $sw = 0;
                $tgl = '';
                $noinv = '';

                // DETAIL
                foreach ($laporan as $lap) {
                    if ($lap['no_invoice'] != $noinv) {
                        if ($sw == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total Amount');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totamt);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            
                            if ($totdisc > 0) {
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total Disc');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totdisc);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            }
                            
                            if ($totdp > 0) {
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total DP');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totdp);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            }                            

                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total DPP');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totdpp);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            
                            
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total PPN');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totppn);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            
                            if ($ongkir > 0) {
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Ongkos Kirim');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $ongkir);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 1;
                            }
                            
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total Invoice');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totnet);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 2;
                            $gtotinv = $gtotinv + $totnet;
                            $totamt = 0;
                        }
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_invoice']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['no_po']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_customer']);
                        $noinv = $lap['no_invoice'];
                    }

                    $totamt = $totamt + $lap['subtotal'];
                    $gtotamt = $gtotamt + $lap['subtotal'];
                    $totdp = $lap['total_dp'];
                    $totdpp = $lap['total_dpp'];
                    $totdisc = $lap['total_discount'];
                    $totppn = $lap['total_ppn'];
                    $totnet = $lap['total_invoice'];
                    $ongkir = $lap['ongkir'];

                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
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
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total Amount');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totamt);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;
                
                if ($totdisc > 0) {                
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total Disc');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totdisc);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;
                }
                
                if ($totdp > 0) {
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total DP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totdp);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;
                }
                
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total DPP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totdpp);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;
                
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total PPN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totppn);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;

                if ($ongkir > 0) {                
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Ongkos Kirim');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $ongkir);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;
                }
                
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total Invoice');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totnet);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                           
                $gtotinv = $gtotinv + $totnet;


                $kolom = $kolom + 3;
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'GRAND TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $gtotinv);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);


                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual17d' .  '.xlsx';
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
