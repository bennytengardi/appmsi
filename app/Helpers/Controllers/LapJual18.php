<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelBarang;
use App\Models\ModelLapJual18;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual18 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual18 = new ModelLapJual18();
    }

    public function index()
    {
        $data = [
            'title'  => 'Sales By Items Detail',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
            'barang' => $this->ModelBarang->alldata(),
        ];
        return view('lapjual18/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $typelap   = $this->request->getPost('typelap');
        $kodebrg   = $this->request->getPost('kode_barang');
        $title = "Sales By Items Detail";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual18->lapjual18($dari, $sampai, $kodebrg, $typelap);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
             return view('lapjual18/tampil', $data);
        }

        if (isset($tombolExport)) {
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


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'NAMA CUSTOMER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'QTY');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'HARGA');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'TOTAL');

                $kolom = 6;
                $nomor = 1;
                $tamt = 0;
                $gtamt = 0;
                $tqty = 0;
                $gtqty = 0;
                $tginv = '';
                $kdbrg = '';
                $sw = 0;

                // DETAIL
                foreach ($laporan as $lap) {
                    if ($kdbrg <> $lap['kode_barang']) {
                        if ($sw == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUBTOTAL');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tqty);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tamt);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                            $kolom = $kolom + 2;
                            $nomor = 1;
                            $tqty = 0;
                            $tamt = 0;
                        }

                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_barang']);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $kdbrg = $lap['kode_barang'];
                        $kolom = $kolom + 1;
                    }

                    $sw = 1;

                    $tamt  = $tamt  + $lap['subtotal'];
                    $gtamt = $gtamt + $lap['subtotal'];
                    $tqty  = $tqty  + $lap['qty'];
                    $gtqty = $gtqty + $lap['qty'];

                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['no_invoice']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['nama_customer']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['qty']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['harga']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['subtotal']);
                    $kolom++;
                    $nomor++;
                }


                // FOOTER TOTAL
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUBTOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tqty);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tamt);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);

                $kolom = $kolom + 2;
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $gtqty);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $gtamt);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);


                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual18' .  '.xlsx';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename = ' . $filename . '');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit;
         }
    }
}
