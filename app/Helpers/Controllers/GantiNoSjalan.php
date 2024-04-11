<?php

namespace App\Controllers;

use App\Models\ModelSuratJln;
use Config\Services;


class GantiNoSjalan extends BaseController
{
    function __construct()
    {
        $this->ModelSuratJln = new ModelSuratJln();
    }

    public function index()
    {
        $data = [
            'title'  => 'Ganti No Srt Jalan',
        ];
        return view('gantinosjalan/filter', $data);
    }

    public function proses()
    {
        if ($this->request->isAJAX()) {
            $nolama = $this->request->getPost('nosjlama');
            $nobaru = $this->request->getPost('nosjbaru');
            $validation =  \Config\Services::validation();
        
            $valid = $this->validate([
                'nosjlama' => [
                    'label' => 'No Srt Jalan Lama',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'nosjbaru' => [
                    'label' => 'No Srt Jalan Baru',
                    'rules' => 'required|is_unique[tbl_suratjln.no_suratjln]',
                    'errors' => [
                        'required'  => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNoSjLama' => $validation->getError('nosjlama'),
                        'errorNoSjBaru' => $validation->getError('nosjbaru'),
                    ]
                ];
                echo json_encode($msg);
            } else {


                $data = [
                    'no_suratjln' => $nobaru
                ];
                $this->ModelSuratJln->gantiNo($nolama,$data);
                
                $msg = [
                    'sukses' => 'Proses Pergantian No Srt Jalan Berhasil !!!'
                ];    
                echo json_encode($msg);
            }
        }
    }
}
