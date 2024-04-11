<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesman;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual06;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual06 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual06 = new ModelLapJual06();
    }

    public function index()
    {
        $data = [
            'title'  => 'AR Subsidary Ledger Summary',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapjual06/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        // $kodesales = $this->request->getPost('kode_salesman');
        $title = "AR Subsidary Ledger Summary";
        $title1 = session()->get('nama_company');

        $customer = $this->ModelCustomer->allData();
        foreach ($customer as $cus) {
            $data = [
                'kode_customer' => $cus['kode_customer'],
                'awldbt' => 0,
                'awlcrd' => 0,
                'crd' => 0,
                'dbt' => 0
            ];
            $this->ModelCustomer->clearSaldo($data);
        }

        $awldbt = $this->ModelLapJual06->awalDebet($dari);
        foreach ($awldbt as $aw1) {
            $cust = $aw1['kode_customer'];
            $nilai = $aw1['awl'];
            $raw1 = [
                'kode_customer' => $cust,
                'awldbt' => $nilai
            ];
            $this->ModelLapJual06->updateSaldoAwal($raw1);
        }

        $awlcrd = $this->ModelLapJual06->awalCredit($dari);
        foreach ($awlcrd as $aw2) {
            $cust = $aw2['kode_customer'];
            $nilai = $aw2['awl'];
            $raw1 = [
                'kode_customer' => $cust,
                'awlcrd' => $nilai
            ];
            $this->ModelLapJual06->updateSaldoAwal($raw1);
        }

        $trxdbt = $this->ModelLapJual06->trxDebet($dari, $sampai);
        foreach ($trxdbt as $trx1) {
            $cust = $trx1['kode_customer'];
            $nilai = $trx1['awl'];
            $raw1 = [
                'kode_customer' => $cust,
                'dbt' => $nilai
            ];
            $this->ModelLapJual06->updateSaldoAwal($raw1);
        }

        $trxcrd = $this->ModelLapJual06->trxCredit($dari, $sampai);
        foreach ($trxcrd as $trx2) {
            $cust = $trx2['kode_customer'];
            $nilai = $trx2['awl'];
            $raw1 = [
                'kode_customer' => $cust,
                'crd' => $nilai
            ];
            $this->ModelLapJual06->updateSaldoAwal($raw1);
        }

        $laporan = $this->ModelCustomer->getSaldo();

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapjual06/tampil', $data);
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


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'Cust#');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'Customer Name');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'Opening Balance');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'Sales Invoice');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'Sales Receipt');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'Ending Balance');

            $kolom = 6;
            $gtotawl = 0;
            $gtotdbt = 0;
            $gtotcrd = 0;
            $gtotakh = 0;
            $kdsales = '';
            $sw = 0;

            // DETAIL

            foreach ($laporan as $lap) {
                $gtotawl = $gtotawl + $lap['awal'] + $lap['awldbt'] - $lap['awlcrd'];
                $gtotdbt = $gtotdbt + $lap['dbt'];
                $gtotcrd = $gtotcrd + $lap['crd'];
                $gtotakh = $gtotakh + $lap['awal'] + $lap['awldbt'] - $lap['awlcrd'] + $lap['dbt'] - $lap['crd'];

                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                if ($lap['awal'] + $lap['awldbt'] + $lap['awlcrd'] + $lap['dbt'] + $lap['crd'] != 0) {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['kode_customer']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['nama_customer']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['awal'] + $lap['awldbt'] - $lap['awlcrd']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['dbt']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['crd']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['awal'] + $lap['awldbt'] - $lap['awlcrd'] + $lap['dbt'] - $lap['crd']);
                    $kolom = $kolom + 1;
                }
            }

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $gtotawl);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $gtotdbt);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $gtotcrd);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $gtotakh);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $kolom = $kolom + 2;

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual06' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
