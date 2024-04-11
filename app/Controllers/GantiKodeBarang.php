<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use Config\Services;


class GantiKodeBarang extends BaseController
{
    function __construct()
    {
        $this->ModelBarang = new ModelBarang();
    }

    public function index()
    {
        $data = [
            'title'  => 'Ganti Kode Barang',
        ];
        return view('gantikodebarang/filter', $data);
    }

    public function proses()
    {
        if ($this->request->isAJAX()) {
            $kodelama = $this->request->getPost('kodelama');
            $kodebaru = $this->request->getPost('kodebaru');
            $validation =  \Config\Services::validation();
        
            $valid = $this->validate([
                'kodelama' => [
                    'label' => 'Kode Lama',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'kodebaru' => [
                    'label' => 'Kode Baru',
                    'rules' => 'required|is_unique[tbl_barang.kode_barang]',
                    'errors' => [
                        'required'  => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeLama' => $validation->getError('kodelama'),
                        'errorKodeBaru' => $validation->getError('kodebaru'),
                    ]
                ];
                echo json_encode($msg);
            } else {


                $data = [
                    'kode_barang' => $kodebaru
                ];
                $this->ModelBarang->gantiKode($kodelama,$data);
                
                $msg = [
                    'sukses' => 'Proses Pergantian Kode Barang Berhasil !!!'
                ];    
                echo json_encode($msg);
            }
        }
    }
}
