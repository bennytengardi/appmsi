<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelAccount;
use App\Models\ModelDataKategori;
use App\Models\ModelLogHistory;
use Config\Services;

class Kategori extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelKategori = new ModelKategori();
        $this->ModelAccount = new ModelAccount();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kategori',
        ];
        return view('kategori/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataKategori = new ModelDataKategori($request);
        if ($request->getMethod(true) == 'POST') {
            $kategori = $this->ModelDataKategori->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($kategori as $sat) {
                $row = [];
                $row[] = $no++;
                $row[] = $sat['kode_kategori'];
                $row[] = $sat['nama_kategori'];
                $row[] =
                    '<a href="' . base_url('kategori/edit/' . $sat['kode_kategori']) . '" class="btn btn-success btn-xs mr-2" style="height: 26px;font-size: 12px;">EDIT</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-sm\" style=\"height: 26px; font-size: 12px;\"  onclick=\"hapusKategori('" . $sat['kode_kategori'] .  "','" . $sat['nama_kategori'] . "') \">DELETE</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataKategori->count_all(),
                "recordsFiltered" => $this->ModelDataKategori->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $data = [
            'title'      => 'Tambah Kategori',
            'account'     => $this->ModelAccount->allData(),
            'validation'  => \config\Services::validation()
        ];
        return view('kategori/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_kategori = $this->request->getVar('kode_kategori');
            $nama_kategori = $this->request->getVar('nama_kategori');
            $kode_accjual  = $this->request->getVar('kode_accjual');
            $kode_acchpp   = $this->request->getVar('kode_acchpp');

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'kode_kategori' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required|is_unique[tbl_kategori.kode_kategori]',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan kode yang lain',
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],

                'nama_kategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kode_accjual' => [
                    'label' => 'Account Penjualan',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kode_acchpp' => [
                    'label' => 'Account HPP',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]


            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeKategori'  => $validation->getError('kode_kategori'),
                        'errorNamaKategori'   => $validation->getError('nama_kategori'),
                        'errorKodeAccJual'   => $validation->getError('kode_accjual'),
                        'errorKodeAccHpp'   => $validation->getError('kode_acchpp'),
                    ]
                ];
            } else {
                //    data sudah Valid
                $data = [
                    'kode_kategori' => $kode_kategori,
                    'nama_kategori' => $nama_kategori,
                    'kode_accjual'  => $kode_accjual,
                    'kode_acchpp'   => $kode_acchpp,
                ];

                $this->ModelKategori->add($data);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Kategori : ' . $nama_kategori,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Kategori Baru Berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($kode_kategori)
    {
        $data = [
            'account'  => $this->ModelAccount->allData(),
            'kategori' => $this->ModelKategori->find($kode_kategori),
        ];
        return view('kategori/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode_kategori  = $this->request->getVar('kode_kategori');
            $nama_kategori  = $this->request->getVar('nama_kategori');
            $kode_accjual  = $this->request->getVar('kode_accjual');
            $kode_acchpp   = $this->request->getVar('kode_acchpp');

            $validation =  \Config\Services::validation();

            $valid = $this->validate([

                'nama_kategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaKategori'   => $validation->getError('nama_kategori'),
                    ]
                ];
            } else {
                $data = [
                    'kode_kategori' => $kode_kategori,
                    'nama_kategori' => $nama_kategori,
                    'kode_accjual'  => $kode_accjual,
                    'kode_acchpp'   => $kode_acchpp,
                ];
                $this->ModelKategori->edit($data);
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Tabel Kategori : ' . $nama_kategori,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Data Kategori Berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kode_kategori = $this->request->getVar('kode_kategori');
            $nama_kategori = $this->request->getVar('nama_kategori');

            $this->ModelKategori->hapus($kode_kategori);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Tabel Kategori : ' . $nama_kategori,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Data Kategori berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
