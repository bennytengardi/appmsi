<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelPurchInv;
use App\Models\ModelPayment;
use App\Models\ModelLapBeli08;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapBeli08 extends BaseController
{
    function __construct()
    {
        $this->ModelPayment  = new ModelPayment();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelLapBeli08 = new ModelLapBeli08();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Outstanding Hutang',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'supplier' => $this->ModelSupplier->allData2(),
        ];
        return view('lapbeli08/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $sampai    = $this->request->getPost('sampai');
        $kodesupp  = $this->request->getPost('kode_supplier');
        $title = "LAPORAN OUTSTANDING HUTANG";
        $title1 = session()->get('nama_company');
        $this->ModelLapBeli08->clearOutstandingHutang();

        if ($kodesupp == "ALL") {
            $dsupp = $this->ModelSupplier->allData2();
        } else {
            $dsupp = $this->ModelSupplier->getCust($kodesupp);
        }
        $trxdbt = $this->ModelLapBeli08->trxDebet($sampai, $kodesupp);

        foreach ($trxdbt as $trx1) {
            $tglbukti  = $trx1['tgl_invoice'];
            $duedate   = $trx1['due_date'];
            $nobukti   = $trx1['no_invoice'];
            $supp      = $trx1['kode_supplier'];
            $nilai     = $trx1['total_invoice'];
            $bayar     = 0;
            $raw2 = [
                'no_invoice'    => $nobukti,
                'tgl_invoice'   => $tglbukti,
                'due_date'      => $duedate,
                'kode_supplier' => $supp,
                'total_invoice' => $nilai,
                'total_bayar'   => $bayar
            ];
            $this->ModelLapBeli08->insertOutstandingHutang($raw2);
        }

        $trxcrd = $this->ModelLapBeli08->trxCredit($sampai, $kodesupp);
        foreach ($trxcrd as $trx2) {
            $noinvoice = $trx2['no_invoice'];
            $bayar     = $trx2['totbyr'];
            // $potongan  = $trx2['potongan'];
            $raw3 = [
                'no_invoice'  => $noinvoice,
                'total_bayar' => $bayar
                // + $potongan
            ];
            // dd($raw3);
            $this->ModelLapBeli08->updateOutstandingHutang($raw3);
        }
        $laporan = $this->ModelLapBeli08->getOutstandingHutang();
        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
                'kd' => $kodesupp
            );
            return view('lapbeli08/tampil', $data);
        }

        if (isset($tombolExport)) {
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
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:E5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:E5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:E5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:E5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TOTAL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'TOTAL BAYAR');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'TOTAL PIUTANG');

            $kolom = 6;
            $totinv = 0;
            $totbyr = 0;
            $totsisa = 0;
            $gtotinv = 0;
            $gtotbyr = 0;
            $gtotsisa = 0;
            $sw = 0;
            $kdsupp = '';
            // DETAIL

            foreach ($laporan as $lap) {
                if ($kdsupp <> $lap['kode_supplier']) {
                    if ($sw == 1) {
                        // $kolom=$kolom+1;
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $totinv);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totbyr);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totsisa);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
                        $totinv = 0;
                        $totbyr = 0;
                        $totsisa = 0;
                        $kolom = $kolom + 2;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(11);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_supplier']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kolom = $kolom + 1;
                }
                $totinv = $totinv + $lap['total_invoice'];
                $totbyr = $totbyr + $lap['total_bayar'];
                $totsisa = $totsisa + ($lap['total_invoice'] - $lap['total_bayar']);
                $gtotinv = $gtotinv + $lap['total_invoice'];
                $gtotbyr = $gtotbyr + $lap['total_bayar'];
                $gtotsisa = $gtotsisa + ($lap['total_invoice'] - $lap['total_bayar']);
                $sw = 1;

                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['total_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['total_bayar']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['total_invoice'] - $lap['total_bayar']);
                $kdsupp  = $lap['kode_supplier'];
                $kolom = $kolom + 1;
            }

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $totinv);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totbyr);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totsisa);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
            $kolom = $kolom + 2;

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $gtotinv);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $gtotbyr);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $gtotsisa);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapbeli08' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
