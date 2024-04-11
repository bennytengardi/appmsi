<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelPurchInv;
use App\Models\ModelPayment;
use App\Models\ModelLapBeli05;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapBeli05 extends BaseController
{
    function __construct()
    {
        $this->ModelPayment  = new ModelPayment();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelLapBeli05 = new ModelLapBeli05();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Pembayaran',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'supplier' => $this->ModelSupplier->allData2(),
        ];
        return view('lapbeli05/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodesupp  = $this->request->getPost('kode_supplier');
        $title = "LAPORAN PEMBAYARAN SUPPLIER";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapBeli05->lapbeli05($dari, $sampai, $kodesupp);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
                'kd'    => $kodesupp
            );
            return view('lapbeli05/tampil', $data);
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
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'TGL BUKTI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO BUKTI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'NO INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'TGL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'TOTAL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'POTONGAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'JUMLAH BAYAR');


            $kolom = 6;
            $nomor = 1;
            $tpot = 0;
            $tbyr = 0;
            $gtpot = 0;
            $gtbyr = 0;
            $sw = 0;
            $kdsupp = '';
            // DETAIL

            foreach ($laporan as $sttb) {
                if ($kdsupp <> $sttb['kode_supplier']) {
                    if ($sw == 1) {
                        $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tpot);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $tbyr);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                        $kolom = $kolom + 1;
                        $tbyr = 0;
                        $tpot = 0;
                    }
                    $kolom = $kolom + 1;
                    $supplier = $this->ModelSupplier->detail($sttb['kode_supplier']);
                    $det = $supplier['nama_supplier'] . '    [' . $supplier['address1'] . ']';
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kdsupp = $sttb['kode_supplier'];
                    $kolom = $kolom + 1;
                }

                $sw = 1;
                $tpot += $sttb['potongan'];
                $tbyr += $sttb['jumlah_bayar'];
                $gtpot += $sttb['potongan'];
                $gtbyr += $sttb['jumlah_bayar'];

                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-M-Y', strtotime($sttb['tgl_receipt'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_receipt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $sttb['no_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, date('d-M-Y', strtotime($sttb['tgl_invoice'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['total_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['potongan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $sttb['jumlah_bayar']);
                $kolom++;
                $nomor++;
            }

            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tpot);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $tbyr);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

            $kolom = $kolom + 2;

            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $gtpot);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $gtbyr);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapbeli05' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
