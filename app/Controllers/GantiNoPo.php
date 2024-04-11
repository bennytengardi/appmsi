<?php

namespace App\Controllers;

use App\Models\ModelPurchOrd;
use Config\Services;


class GantiNoPo extends BaseController
{
    function __construct()
    {
        $this->ModelPurchOrd = new ModelPurchOrd();
    }

    public function index()
    {
        $data = [
            'title'  => 'Ganti PO',
        ];
        return view('gantinopo/filter', $data);
    }

    public function proses()
    {
        if ($this->request->isAJAX()) {
            $nolama = $this->request->getPost('nopolama');
            $nobaru = $this->request->getPost('nopobaru');
            $validation =  \Config\Services::validation();
        
            $valid = $this->validate([
                'nopolama' => [
                    'label' => 'No PO Lama',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'nopobaru' => [
                    'label' => 'No PO Baru',
                    'rules' => 'required|is_unique[tbl_purchord.no_po]',
                    'errors' => [
                        'required'  => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNoPoLama' => $validation->getError('nopolama'),
                        'errorNoPoBaru' => $validation->getError('nopobaru'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $data = [
                    'no_po' => $nobaru
                ];
                $this->ModelPurchOrd->gantiNo($nolama,$data);
                
                $msg = [
                    'sukses' => 'Proses Pergantian No PO Berhasil !!!'
                ];    
                echo json_encode($msg);
            }
        }
    }
}
