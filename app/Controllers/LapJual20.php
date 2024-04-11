<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual20;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual20 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual20 = new ModelLapJual20();
    }

    public function index()
    {
        $data = [
            'title'  => 'Aging Receivable Summary',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'customer' => $this->ModelCustomer->alldata2(),
        ];
        return view('lapjual20/filter', $data);
    }

    public function preview()
    {
        $tombolCetak  = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $sampai    = $this->request->getPost('sampai');
        $kodecust  = $this->request->getPost('kode_customer');
        $title1    = session()->get('nama_company');
        $title = "Aging Receivable Summary";
        $this->ModelLapJual20->clearOutstandingPiutang();

        if ($kodecust == "ALL") {
            $dcust = $this->ModelCustomer->allData2();
        } else {
            $dcust = $this->ModelCustomer->getCust($kodecust);
        }
        $trxdbt = $this->ModelLapJual20->trxDebet($sampai, $kodecust);
        foreach ($trxdbt as $trx1) {
            $tglbukti  = $trx1['tgl_invoice'];
            $duedate   = $trx1['due_date'];
            $nobukti   = $trx1['no_invoice'];
            $cust      = $trx1['kode_customer'];
            $nilai     = $trx1['total_invoice'];
            $bayar     = 0;
            $raw2 = [
                'no_invoice'    => $nobukti,
                'tgl_invoice'   => $tglbukti,
                'due_date'      => $duedate,
                'kode_customer' => $cust,
                'total_invoice' => $nilai,
                'total_bayar'   => $bayar
            ];
            $this->ModelLapJual20->insertOutstandingPiutang($raw2);
        }



        $trxcrd = $this->ModelLapJual20->trxCredit($sampai, $kodecust);
        foreach ($trxcrd as $trx2) {
            $noinvoice = $trx2['no_invoice'];
            $bayar     = $trx2['totbyr'];
            // $potongan  = $trx2['potongan'];
            $raw3 = [
                'no_invoice'  => $noinvoice,
                'total_bayar' => $bayar
                // + $potongan
            ];
            $this->ModelLapJual20->updateOutstandingPiutang($raw3);
        }

        $trxrtn = $this->ModelLapJual20->trxRetur($sampai, $kodecust);
        foreach ($trxrtn as $trx3) {
            $noinvoice = $trx3['no_invoice'];
            $retur     = $trx3['total_retur'];
            $raw3 = [
                'no_invoice'  => $noinvoice,
                'total_retur' => $retur
            ];
            $this->ModelLapJual20->updateOutstandingPiutang($raw3);
        }

        $laporan = $this->ModelLapJual20->getOutstandingPiutang();

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
                'sampai' => $sampai,
                'kd' => $kodecust
            );
            return view('lapjual20/tampil', $data);
        }

        if (isset($tombolExport)) {
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
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', '0-30 HARI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', '31-60 HARI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', '61-90 HARI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', '> 90 HARI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'TOTAL');


            $kolom = 6;
            $tot30 = 0;
            $tot60 = 0;
            $tot90 = 0;
            $tot120 = 0;
            $gtot30 = 0;
            $gtot60 = 0;
            $gtot90 = 0;
            $gtot120 = 0;
            $total = 0;
            $gtotal = 0;
            $sw = 0;
            $kdcust = '';
            // DETAIL

            foreach ($laporan as $lap) {
                if ($kdcust != $lap['nama_customer'] . $lap['kode_customer']) {
                    if ($sw == 1) {
                        // $kolom=$kolom+1;
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $tot30);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tot60);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $tot90);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tot120);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $total);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                        $tot30 = 0;
                        $tot60 = 0;
                        $tot90 = 0;
                        $tot120 = 0;
                        $total = 0;
                        $kolom = $kolom + 2;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(10);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_customer']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kolom = $kolom + 1;
                }

                $tgl2 = strtotime($sampai);
                $tgl1 = strtotime($lap['tgl_invoice']);
                $jarak = $tgl2 - $tgl1;
                $hari = $jarak / 60 / 60 / 24;
                if ($hari <= 30) {
                    $tot30   = $tot30  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                    $gtot30   = $gtot30  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                } else {
                    if ($hari <= 60) {
                        $tot60   = $tot60  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        $gtot60   = $gtot60  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                    } else {
                        if ($hari <= 90) {
                            $tot90   = $tot90  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                            $gtot90   = $gtot90  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        } else {
                            $tot120  = $tot120 + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                            $gtot120  = $gtot120 + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        }
                    }
                }

                $total   = $total  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                $gtotal   = $gtotal  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                $sw = 1;

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));

                if ($hari <= 30) {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                } else {
                    if ($hari <= 60) {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                    } else {
                        if ($hari <= 90) {
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        } else {
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        }
                    }
                }
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $kdcust =  $lap['nama_customer'] . $lap['kode_customer'];
                $kolom = $kolom + 1;
            }

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $tot30);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tot60);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $tot90);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tot120);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $total);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
            $kolom = $kolom + 2;

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);

            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(10);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $gtot30);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $gtot60);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $gtot90);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $gtot120);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $gtotal);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual14' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
