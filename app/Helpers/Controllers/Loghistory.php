<?php

namespace App\Controllers;

use App\Models\ModelLogHistory;
use App\Models\ModelDataLogHistory;

use Config\Services;

class LogHistory extends BaseController

{
    public function __construct()
    {
        helper('form');
        $this->ModelLogHistory   = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Login History',
        ];
        return view('loghistory/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataLogHistory = new ModelDataLogHistory($request);
        if ($request->getMethod(true) == 'POST') {
            $log = $this->ModelDataLogHistory->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($log as $lg) {
                $row = [];
                $row[] = $no++;
                $row[] = $lg['username'];
                // $row[] = $lg['jamtrx'];
                $row[] = date('d-m-Y H:i:s', strtotime($lg['jamtrx']));
                $row[] = $lg['kegiatan'];
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataLogHistory->count_all(),
                "recordsFiltered" => $this->ModelDataLogHistory->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    
    public function hapusLog()
    {
        if ($this->request->isAJAX()) {
            $this->ModelLogHistory->hapus();
            $msg = ['sukses' => 'Data Log History berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}