<?php

namespace App\Controllers;

use App\Models\ModelSalesOrd;
use Config\Services;


class GantiNoSo extends BaseController
{
    function __construct()
    {
        $this->ModelSalesOrd = new ModelSalesOrd();
    }

    public function index()
    {
        $data = [
            'title'  => 'Ganti No Sales Order',
        ];
        return view('gantinoso/filter', $data);
    }

    public function proses()
    {
        if ($this->request->isAJAX()) {
            $nolama = $this->request->getPost('nosolama');
            $nobaru = $this->request->getPost('nosobaru');
            $validation =  \Config\Services::validation();
        
            $valid = $this->validate([
                'nosolama' => [
                    'label' => 'No SO Lama',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'nosobaru' => [
                    'label' => 'No SO Baru',
                    'rules' => 'required|is_unique[tbl_salesord.no_so]',
                    'errors' => [
                        'required'  => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNoSoLama' => $validation->getError('nosolama'),
                        'errorNoSoBaru' => $validation->getError('nosobaru'),
                    ]
                ];
                echo json_encode($msg);
            } else {


                $data = [
                    'no_so' => $nobaru
                ];
                $this->ModelSalesOrd->gantiNo($nolama,$data);
                
                $msg = [
                    'sukses' => 'Proses Pergantian No SO Berhasil !!!'
                ];    
                echo json_encode($msg);
            }
        }
    }
}
