<?php

namespace App\Controllers;

use App\Models\ModelAccount;
use App\Models\ModelDataAccount;
use App\Models\ModelCurrency;
use App\Models\ModelGroupAcc;
use App\Models\ModelLogHistory;
use Config\Services;


class Account extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelAccount  = new ModelAccount();
        $this->ModelCurrency = new ModelCurrency();
        $this->ModelGroupAcc = new ModelGroupAcc();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Perkiraan',
        ];
        return view('account/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataAccount = new ModelDataAccount($request);
        if ($request->getMethod(true) == 'POST') {
            $account = $this->ModelDataAccount->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($account as $acct) {
                $row = [];
                $row[] = $no++;
                if($acct['type_account'] == "HEADER") {
                    $row[] = '<b>' . $acct['kode_account'] . '</b>';
                    $row[] = '<b>' . $acct['nama_account'] . '</b>';
                    $row[] = '<b>' . $acct['nama_group'] . '</b>';
                    $row[] = '<b>' . $acct['type_account'] . '</b>';
                    $row[] = '<b>' . $acct['currency'] . '</b>';
                } else {
                    $row[] = '&nbsp&nbsp&nbsp&nbsp' . $acct['kode_account'];
                    $row[] = $acct['nama_account'];
                    $row[] = $acct['nama_group'];
                    $row[] = $acct['type_account'];
                    $row[] = $acct['currency'];
                }
                $row[] =
                    '<a href="' . base_url('account/edit/' . $acct['kode_account']) . '" class="btn btn-success btn-xs mr-2">Edit</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\"  onclick=\"hapusAccount('" . $acct['kode_account'] .  "','" . $acct['nama_account'] . "') \">Delete</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataAccount->count_all(),
                "recordsFiltered" => $this->ModelDataAccount->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $data = [
            'title'      => 'ADD ACCOUNT',
            'currency'  => $this->ModelCurrency->allData(),
            'groupacc'  => $this->ModelGroupAcc->allData(),
            'validation'  => \config\Services::validation()
        ];
        return view('account/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_account    = $this->request->getPost('kode_account');
            $nama_account    = $this->request->getPost('nama_account');
            $kode_group      = $this->request->getPost('kode_group');
            $type_account    = $this->request->getPost('type_account');
            $currency        = $this->request->getPost('currency');
            if ($currency == "IDR") {
                $kurs = 1;
            } else {
                $kurs            = $this->request->getPost('kurs');
            }
            $tgl_awal        = $this->request->getPost('tgl_awal');
            $saldo_awal      = str_replace(',', '', $this->request->getPost('saldo_awal'));
            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'kode_account' => [
                    'label' => 'Account No',
                    'rules' => 'required|is_unique[tbl_account.kode_account]',
                    'errors' => [
                        'is_unique' => '{field} already exist',
                        'required'  => '{field} is required'
                    ]
                ],
                'nama_account' => [
                    'label' => 'Account Name',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_group' => [
                    'label' => 'Group Account',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeAccount'   => $validation->getError('kode_account'),
                        'errorNamaAccount'   => $validation->getError('nama_account'),
                        'errorKodeGroup'     => $validation->getError('kode_group'),
                    ]
                ];
            } else {
                $data = [
                    'kode_account'   => $kode_account,
                    'nama_account'   => $nama_account,
                    'kode_group'     => $kode_group,
                    'type_account'   => $type_account,
                    'sub_account'    => substr($kode_account,0,-4),
                    'currency'       => $currency,
                    'kurs'           => $kurs,
                    'tgl_awal'       => $tgl_awal,
                    'saldo_awal'     => $saldo_awal
                ];

                $this->ModelAccount->add($data);
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Perkiraan : ' . $nama_account,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'New Account has been added '
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($kode_account)
    {
        $data = [
            'account'     => $this->ModelAccount->detail($kode_account),
            'currency'    => $this->ModelCurrency->allData(),
            'groupacc'    => $this->ModelGroupAcc->allData(),
            'validation'  => \config\Services::validation()
        ];
        return view('account/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode_account    = $this->request->getPost('kode_account');
            $nama_account    = $this->request->getPost('nama_account');
            $kode_group      = $this->request->getPost('kode_group');
            $type_account    = $this->request->getPost('type_account');
            $currency        = $this->request->getPost('currency');
            if ($currency == "IDR") {
                $kurs = 1;
            } else {
                $kurs            = $this->request->getPost('kurs');
            }
            $tgl_awal        = $this->request->getPost('tgl_awal');
            $saldo_awal      = str_replace(',', '', $this->request->getPost('saldo_awal'));

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'nama_account' => [
                    'label' => 'Account Name',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaPerkiraan'   => $validation->getError('nama_perkiraan'),
                    ]
                ];
            } else {
                $data = [
                    'kode_account'   => $kode_account,
                    'nama_account'   => $nama_account,
                    'kode_group'     => $kode_group,
                    'type_account'   => $type_account,
                    'sub_account'    => substr($kode_account,0,-4),
                    'currency'       => $currency,
                    'kurs'           => $kurs,
                    'tgl_awal'       => $tgl_awal,
                    'saldo_awal'     => $saldo_awal
                ];

                $this->ModelAccount->edit($data);
                
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Tabel Perkiraan : ' . $nama_account,
                ];
                $this->ModelLogHistory->add($datalog);
                
                $msg = [
                    'sukses' => 'Account has been updated'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kode_account = $this->request->getVar('kode_account');
            $nama_account = $this->request->getVar('nama_account');

            $this->ModelAccount->hapus($kode_account);
            $msg = ['sukses' => 'Account has been Deleted !!!'];
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Tabel Pekiraan : ' . $nama_perkiraan,
            ];
            $this->ModelLogHistory->add($datalog);
            
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_kodeaccount()
    {
        $kode_account = $this->request->getPost('kode_account');
        $data = $this->ModelAccount->detail($kode_account);
        echo json_encode($data);
    }

    public function cari_kodeacct()
    {
        $kode_account = $this->request->getPost('kode_acct');
        $data = $this->ModelAccount->detail($kode_account);
        echo json_encode($data);
    }


   

}
