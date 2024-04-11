<?php

namespace App\Controllers;

use App\Models\ModelSatuan;
use App\Models\ModelDataSatuan;
use Config\Services;

class Satuan extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelSatuan = new ModelSatuan();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Satuan',
        ];
        return view('satuan/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataSatuan = new ModelDataSatuan($request);
        if ($request->getMethod(true) == 'POST') {
            $satuan = $this->ModelDataSatuan->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($satuan as $sat) {
                $row = [];
                $row[] = $no++;
                $row[] = $sat['kode_satuan'];
                $row[] = $sat['nama_satuan'];
                $row[] = '<center>'.
                    '<a href="' . base_url('satuan/edit/' . $sat['kode_satuan']) . '" class="btn btn-success btn-xs mr-2">Edit</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\"  onclick=\"hapusSatuan('" . $sat['kode_satuan'] .  "','" . $sat['nama_satuan'] . "') \">Delete</button>".
                    '</center>';                    
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataSatuan->count_all(),
                "recordsFiltered" => $this->ModelDataSatuan->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $data = [
            'title'      => 'Tambah Satuan',
            'validation'  => \config\Services::validation()
        ];
        return view('satuan/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_satuan = $this->request->getVar('kode_satuan');
            $nama_satuan = $this->request->getVar('nama_satuan');

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'kode_satuan' => [
                    'label' => 'Kode Satuan',
                    'rules' => 'required|is_unique[tbl_satuan.kode_satuan]',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan kode yang lain',
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],

                'nama_satuan' => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeSatuan'  => $validation->getError('kode_satuan'),
                        'errorNamaSatuan'   => $validation->getError('nama_satuan'),
                    ]
                ];
            } else {
                //    data sudah Valid
                $data = [
                    'kode_satuan' => $kode_satuan,
                    'nama_satuan' => $nama_satuan,
                ];

                $this->ModelSatuan->add($data);
                $msg = [
                    'sukses' => 'Satuan Baru Berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($kode_satuan)
    {
        $data = [
            'satuan' => $this->ModelSatuan->find($kode_satuan),
        ];
        return view('satuan/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode_satuan  = $this->request->getVar('kode_satuan');
            $nama_satuan  = $this->request->getVar('nama_satuan');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([

                'nama_satuan' => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaSatuan'   => $validation->getError('nama_satuan'),
                    ]
                ];
            } else {
                $data = [
                    'kode_satuan' => $kode_satuan,
                    'nama_satuan' => $nama_satuan,
                ];
                $this->ModelSatuan->edit($data);
                $msg = [
                    'sukses' => 'Data Satuan Berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function delete($barcode)
    {
        $data = [
            'barcode' => $barcode,
        ];
        $barang = $this->ModelBarang->detail($barcode);
        if ($barang['gambar'] != 'noimage.jpg') {
            unlink('fotoproduk/' . $barang['gambar']);
        }
        $this->ModelBarang->delete_data($data);
        session()->setFlashdata('pesan', 'Data Item has been deleted !!!');
        return redirect()->to(base_url('barang'));
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kode_satuan = $this->request->getVar('kode_satuan');

            $this->ModelSatuan->hapus($kode_satuan);
            $msg = ['sukses' => 'Data Satuan berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
