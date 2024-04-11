<?php

namespace App\Controllers;

use App\Models\ModelAdjustment;
use App\Models\ModelDataAdjustment;
use App\Models\ModelBarang;
use App\Models\ModelCounter;
use App\Models\ModelLogHistory;
use Config\Services;

class Adjustment extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelAdjustment = new ModelAdjustment();
        $this->ModelBarang = new ModelBarang();
        $this->ModelCounter = new ModelCounter();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Adjustment Barang Jadi',
        ];
        return view('adjustment/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataAdjustment = new ModelDataAdjustment($request);
        if ($request->getMethod(true) == 'POST') {
            $adjustment = $this->ModelDataAdjustment->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($adjustment as $adj) {
                $row = [];
                $row[] = $no++;
                $row[] = $adj['no_adjustment'];
                $row[] = date('d-m-Y', strtotime($adj['tgl_adjustment']));
                $row[] = $adj['kode_barang'];
                $row[] = $adj['nama_barang'];
                $row[] = $adj['qty'];
                $row[] = $adj['keterangan'];
                if (session()->get('level') == "1") {
                    $row[] =
                        '<a href="' . base_url('Adjustment/edit/' . $adj['no_adjustment']) . '" class="btn btn-success btn-xs mr-2">EDIT</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusAdjustment('" . $adj['no_adjustment'] . "') \">DELETE</button>";
                } else {
                    $row[] = '';
                }

                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataAdjustment->count_all(),
                "recordsFiltered" => $this->ModelDataAdjustment->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['adjustment'] + 1)), 5, '0', STR_PAD_LEFT);
        $no_adjustment = $nomor . '-STO-' . date('Y');
        $tgl_adjustment = date('Y-m-d');
        $data = [
            'no_adjustment'   => $no_adjustment,
            'tgl_adjustment'  => $tgl_adjustment,
            'barang' => $this->ModelBarang->allData(),
            'validation' => \config\Services::validation()
        ];
        return view('adjustment/v_add', $data);
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_adjustment  = $this->request->getPost('no_adjustment');
            $tgl_adjustment = $this->request->getPost('tgl_adjustment');
            $kode_barang    = $this->request->getPost('kode_barang');
            $stockcomp      = $this->request->getPost('stockcomp');
            $stockfisik     = $this->request->getPost('stockfisik');
            $qty            = $this->request->getPost('qty');
            $keterangan     = $this->request->getpost('keterangan');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_barang' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorkode_barang'  => $validation->getError('kode_barang'),
                    ]
                ];
            } else {
                $data = [
                    'no_adjustment'  => $no_adjustment,
                    'tgl_adjustment' => $tgl_adjustment,
                    'kode_barang'    => $kode_barang,
                    'qty'            => $qty,
                    'stockcomp'      => $stockcomp,
                    'stockfisik'     => $stockfisik,
                    'keterangan'     => $keterangan,
                ];

                $this->ModelAdjustment->add($data);

                // Update Counter Customer
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['adjustment'] + 1;
                $data = [
                    'adjustment' => $inv
                ];
                $this->ModelCounter->updctr($data);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Adjustment Stock : ' . $no_adjustment,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Data Stock Opname Berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($no_adjustment)
    {
        $data = [
            'barang' => $this->ModelBarang->allData(),
            'adjustment'  => $this->ModelAdjustment->detail($no_adjustment),
            'validation'  => \config\Services::validation()
        ];
        return view('adjustment/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $no_adjustment  = $this->request->getPost('no_adjustment');
            $tgl_adjustment = $this->request->getPost('tgl_adjustment');
            $kode_barang    = $this->request->getPost('kode_barang');
            $stockcomp      = $this->request->getPost('stockcomp');
            $stockfisik     = $this->request->getPost('stockfisik');
            $qty            = $this->request->getPost('qty');
            $keterangan     = $this->request->getpost('keterangan');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_barang' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                // 'keterangan' => [
                //     'label' => 'Sebab Adjustment',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required'  => '{field} Wajib Diisi'
                //     ]
                // ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorkode_barang'  => $validation->getError('kode_barang'),
                        // 'errorketerangan'   => $validation->getError('keterangan'),
                    ]
                ];
            } else {
                $data = [
                    'no_adjustment'  => $no_adjustment,
                    'tgl_adjustment' => $tgl_adjustment,
                    'kode_barang'    => $kode_barang,
                    'qty'            => $qty,
                    'stockcomp'      => $stockcomp,
                    'stockfisik'     => $stockfisik,
                    'keterangan'     => $keterangan,
                ];

                $this->ModelAdjustment->edit($data);
                
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Adjustment Stock : ' . $no_adjustment,
                ];
                $this->ModelLogHistory->add($datalog);
                
                $msg = [
                    'sukses' => 'Data Stock Opname Berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $no_adjustment = $this->request->getVar('no_adjustment');
            $this->ModelAdjustment->hapus($no_adjustment);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Adjustment Stock : ' . $no_adjustment,
            ];
            $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Data Stock Opname stok berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
