<?php

namespace App\Controllers;

use App\Models\ModelJurnal;
use App\Models\ModelDataHistory;
use App\Models\ModelAccount;
use Config\Services;

class History extends BaseController
{
    public function __construct()
    {
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelAccount  = new ModelAccount();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlhistory', $date);
        session()->set('tglakhhistory', date('Y-m-d'));
        session()->set('accthistory', 'ALL');
        session()->set('srchistory', 'All Source');
        $data = [
            'account'    => $this->ModelAccount->allDataDetail(),
        ];
        return view('history/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataHistory = new ModelDataHistory($request);
        if ($request->getMethod(true) == 'POST') {
            $history = $this->ModelDataHistory->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($history as $his) {
                $row = [];
                $row[] = $no++;
                $row[] = date('d-m-Y', strtotime($his['tgl_voucher']));
                $row[] = $his['codejurnal'];
                $row[] = $his['no_voucher'];
                $row[] = $his['kode_account'];
                $row[] = $his['nama_account'];
                $row[] = $his['keterangan'];
                if ($his['debet'] != 0) {
                    $row[] = number_format($his['debet'], '2', ',', '.');
                    $row[] ='';
                } else {
                    $row[] ='';
                    $row[] = number_format($his['credit'],'2', ',', '.');
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataHistory->count_all(),
                "recordsFiltered" => $this->ModelDataHistory->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function setses()
    {
        if ($this->request->isAJAX()) {
            $tgl1 = $this->request->getPost('tgl1');
            $tgl2 = $this->request->getPost('tgl2');
            $acct1 = $this->request->getPost('acct');
            $src1  = $this->request->getPost('srch');

            session()->set('tglawlhistory', $tgl1);
            session()->set('tglakhhistory', $tgl2);
            session()->set('accthistory', $acct1);
            session()->set('srchistory', $src1);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

}
