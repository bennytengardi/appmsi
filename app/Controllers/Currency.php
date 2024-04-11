<?php

namespace App\Controllers;

use App\Models\ModelCurrency;
use App\Models\ModelDataCurrency;
use App\Models\ModelLogHistory;
use Config\Services;

class Currency extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelCurrency = new ModelCurrency();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Currency',
        ];
        return view('currency/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataCurrency = new ModelDataCurrency($request);
        if ($request->getMethod(true) == 'POST') {
            $currency = $this->ModelDataCurrency->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($currency as $cur) {
                $row = [];
                $row[] = $no++;
                $row[] = $cur['currency'];
                $row[] = $cur['nama_negara'];
                $row[] = $cur['nilai_tukar'];
                $row[] = $cur['simbol'];
                $row[] = '<center>'.
                    '<a href="' . base_url('currency/edit/' . $cur['currency']) . '" class="btn btn-success btn-xs mr-2">Edit</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\"  onclick=\"hapusCurrency('" . $cur['currency']  . "') \">Delete</button>".
                    '</center>';                    
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataCurrency->count_all(),
                "recordsFiltered" => $this->ModelDataCurrency->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $data = [
            'title'      => 'Tambah Currency',
            'validation'  => \config\Services::validation()
        ];
        return view('currency/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $currency    = $this->request->getVar('currency');
            $nama_negara = $this->request->getVar('nama_negara');
            $nilai_tukar = $this->request->getVar('nilai_tukar');
            $simbol      = $this->request->getVar('simbol');

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'currency' => [
                    'label' => 'Currency',
                    'rules' => 'required|is_unique[tbl_currency.currency]',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan kode yang lain',
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorCurrency'  => $validation->getError('currency'),
                    ]
                ];
            } else {
                //    data sudah Valid
                $data = [
                    'currency' => $currency,
                    'nama_negara' => $nama_negara,
                    'nilai_tukar' => $nilai_tukar,
                    'simbol' => $simbol,
                ];

                $this->ModelCurrency->add($data);
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Currency : ' . $currency,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Data Currency Baru Berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($currency)
    {
        $data = [
            'currency' => $this->ModelCurrency->detail($currency),
        ];
        return view('currency/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $currency    = $this->request->getVar('currency');
            $nama_negara = $this->request->getVar('nama_negara');
            $nilai_tukar = $this->request->getVar('nilai_tukar');
            $simbol      = $this->request->getVar('simbol');
            $validation =  \Config\Services::validation();

            $data = [
                'currency' => $currency,
                'nama_negara' => $nama_negara,
                'nilai_tukar' => $nilai_tukar,
                'simbol' => $simbol,
            ];
            $this->ModelCurrency->edit($data);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Merubah Tabel Currency : ' . $currency,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = [
                'sukses' => 'Data Currency Berhasil diupdate'
            ];
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $currency = $this->request->getVar('currency');

            $this->ModelCurrency->hapus($currency);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Tabel Currency : ' . $currency,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Data Currency berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
    
    public function cari_currency()
    {
        $currency = $this->request->getPost('currency');
        $data = $this->ModelCurrency->detail($currency);
        echo json_encode($data);
    }

}
