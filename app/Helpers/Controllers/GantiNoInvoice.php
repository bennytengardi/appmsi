<?php

namespace App\Controllers;

use App\Models\ModelSalesInv;
use Config\Services;


class GantiNoInvoice extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
    }

    public function index()
    {
        $data = [
            'title'  => 'Ganti No Invoice',
        ];
        return view('gantinoinvoice/filter', $data);
    }

    public function proses()
    {
        if ($this->request->isAJAX()) {
            $nolama = $this->request->getPost('noinvlama');
            $nobaru = $this->request->getPost('noinvbaru');
            $validation =  \Config\Services::validation();
        
            $valid = $this->validate([
                'noinvlama' => [
                    'label' => 'No Invoice Lama',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'noinvbaru' => [
                    'label' => 'No Invoice Baru',
                    'rules' => 'required|is_unique[tbl_salesinv.no_invoice]',
                    'errors' => [
                        'required'  => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNoInvLama' => $validation->getError('noinvlama'),
                        'errorNoInvBaru' => $validation->getError('noinvbaru'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $data = [
                    'no_invoice' => $nobaru
                ];
                $data2 = [
                    'no_voucher' => $nobaru
                ];
                
                $this->ModelSalesInv->gantiNo($nolama,$data, $data2);
                $msg = [
                    'sukses' => 'Proses Pergantian No Invoice Berhasil !!!'
                ];    
                echo json_encode($msg);
            }
        }
    }
}
