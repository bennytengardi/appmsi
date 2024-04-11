<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesOrd;
use App\Models\ModelBarang;
use App\Models\ModelDivisi;
use App\Models\ModelLapJual22;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual22 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesOrd = new ModelSalesOrd();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelDivisi = new ModelDivisi();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual22 = new ModelLapJual22();
    }

    public function index()
    {
        $data = [
            'title' => 'Sales By Division',
            'divisi' => $this->ModelDivisi->allData(),
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapjual22/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodedivisi  = $this->request->getPost('kode_divisi');
        $typelap   = $this->request->getPost('typelap');
        $title = "Sales Order By Division";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual22->lapjual22($dari, $sampai,$kodedivisi, $typelap);


        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'divisi'  => $kodedivisi,
                'laporan' => $laporan,
            );
            if ($typelap == 'REKAP') {
                return view('lapjual22/tampil', $data);
            } else {
                return view('lapjual22/tampildetail', $data);
            }
        }

        if (isset($tombolExport)) {

            if ($typelap == 'REKAP') {

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

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $kodedivisi);

                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);


                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO SO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL SO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NAMA CUSTOMER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'TOTAL AMOUNT');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'TOTAL PPN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'TOTAL SO');


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
                    $t05 += $sttb['total_ppn'];
                    $t07 += $sttb['total_so'];

                    $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $nomor);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_so']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($sttb['tgl_so'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['nama_customer']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['total_amount']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $sttb['total_ppn']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $kolom, $sttb['total_so']);
                    $kolom++;
                    $nomor++;
                }

                // FOOTER TOTAL


                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $t01);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $t05);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $t07);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual22' .  '.xlsx';
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
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(1);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(8);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);
               

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO SO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL SO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', '');
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
                $totnet = 0;
                $gtotinv = 0;
                $sw = 0;
                $tgl = '';
                $noinv = '';

                // DETAIL
                foreach ($laporan as $lap) {
                    if ($lap['no_so'] != $noinv) {
                        if ($sw == 1) {
                            $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                            $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total Amount');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totamt);
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
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_so']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_so'])));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_customer']);
                        $noinv = $lap['no_so'];
                    }

                    $totamt = $totamt + $lap['subtotal'];
                    $gtotamt = $gtotamt + $lap['subtotal'];
                    $totppn = $lap['total_ppn'];
                    $totnet = $lap['total_so'];

                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['nama_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['qty']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['kode_satuan']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $lap['harga']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $lap['subtotal']);
                    $noinv = $lap['no_so'];
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
                
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total PPN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $totppn);
                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getFont()->setBold(true);
                $kolom = $kolom + 1;


                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('G' . $kolom . ':' . 'H' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 'Total SO');
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
                $filename = 'lapjual22d' .  '.xlsx';
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
