<?php

namespace App\Controllers;

use App\Models\ModelOthRcv;
use App\Models\ModelDataOthRcv;
use App\Models\ModelDataAccount2;
use App\Models\ModelJurnal;
use App\Models\ModelAccount;
use App\Models\ModelCounter;
use App\Models\ModelLogHistory;
use Config\Services;

class OthRcv extends BaseController
{
    public function __construct()
    {
        $this->ModelOthRcv   = new ModelOthRcv();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelAccount  = new ModelAccount();
        $this->ModelCounter  = new ModelCounter();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlothrcv', $date);
        session()->set('tglakhothrcv', date('Y-m-d'));
        session()->set('acct1', 'ALL');
        $data = [
            'account'    => $this->ModelAccount->allDataBank(),
        ];
        return view('othrcv/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataOthRcv = new ModelDataOthRcv($request);
        if ($request->getMethod(true) == 'POST') {
            $othrcv = $this->ModelDataOthRcv->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($othrcv as $cr) {
                $row = [];
                $row[] = $no++;
                $row[] = $cr['no_bukti'];
                $row[] = date('d-m-Y', strtotime($cr['tgl_bukti']));
                $row[] = $cr['nama_account'];
                $row[] = number_format($cr['total'], '2', ',', '.');
                $row[] = $cr['currency'];
                $row[] = $cr['keterangan'];
                $row[] =
                    '<a href="' . base_url('OthRcv/edit/' . $cr['id_bukti']) . '" class="btn btn-success btn-xs mr-2"><i class="fa fa-edit"></i> Edit</a>' .
                    '<a href="' . base_url('OthRcv/detail/' . $cr['id_bukti']) . '" class="btn btn-info btn-xs mr-2"><i class="fa fa-eye"></i> Detail</a>' .
                    '<a href="' . base_url('OthRcv/print/' . $cr['id_bukti']) . '" class="btn btn-primary btn-xs mr-2"><i class="fa fa-print"></i> Print</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusOthRcv('" . $cr['id_bukti'] . "','" . $cr['no_bukti'] . "') \"><i class='fa fa-trash-alt'></i> Delete</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataOthRcv->count_all(),
                "recordsFiltered" => $this->ModelDataOthRcv->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $no_random = rand();
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['othrcv'])), 5, '0', STR_PAD_LEFT);
        $no_bukti  = $nomor . '-OD-' . date('Y');
        $tgl_bukti = date('Y-m-d');
        $data = [
            'no_bukti'   => $no_bukti,
            'no_random'  => $no_random,
            'tgl_bukti'  => $tgl_bukti,
            'account'    => $this->ModelAccount->allDataBank(),
            'accountall' => $this->ModelAccount->allDataDetail(),
            'validation' => \config\Services::validation()
        ];
        $this->ModelOthRcv->clearCart($no_random);
        return view('othrcv/v_add', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_bukti = $this->request->getPost('no_bukti');
            $dtl      = $this->ModelOthRcv->getCart($no_bukti);
            $data  = [
                'datadetail' => $dtl
            ];
            $msg = [
                'data' => view('othrcv/v_harga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function viewDataAccount()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');

            $data = [
                'keyword' => $keyword,
            ];
            $msg = [
                'viewmodal' => view('othrcv/v_cariaccount', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function listDataAccount()
    {
        if ($this->request->isAJAX()) {
            $keywordkodeaccount = $this->request->getPost('keywordkodeaccount');
            $request = Services::request();
            $modeldataaccount = new ModelDataAccount2($request);
            if ($request->getMethod(true) == 'POST') {
                $lists = $modeldataaccount->get_datatables($keywordkodeaccount);
                $data = [];
                $no = $request->getPost("start");
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list['kode_account'];
                    $row[] = $list['nama_account'];
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-info\" style=\"height: 26px; font-size: 12px;\"  onclick=\"pilihitem('" . $list['kode_account'] . "','" . $list['nama_account'] . "')\" ><i class=\"fa fa-check\"></i></button>";
                    $data[] = $row;
                }
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => $modeldataaccount->count_all($keywordkodeaccount),
                    "recordsFiltered" => $modeldataaccount->count_filtered($keywordkodeaccount),
                    "data" => $data
                ];
                echo json_encode($output);
            }
        }
    }

    public function setses()
    {
        if ($this->request->isAJAX()) {
            $tgl1 = $this->request->getPost('tgl1');
            $tgl2 = $this->request->getPost('tgl2');
            $acct1 = $this->request->getPost('acct');

            session()->set('tglawlothrcv', $tgl1);
            session()->set('tglakhothrcv', $tgl2);
            session()->set('acct1', $acct1);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            if (empty($this->request->getPost('jumlah'))) {
                $jumlah = 0;
            } else {
                $jumlah = str_replace(',', '', $this->request->getPost('jumlah'));
            }
            $no_random    = $this->request->getPost('no_random');
            $kode_account = $this->request->getPost('kode_acct');
            $nama_account = $this->request->getPost('nama_acct');
            $keterangan   = $this->request->getPost('remark');

            if (strlen($nama_account) > 0) {
                $queryCekAccount = $this->db->table('tbl_account')
                    ->where('kode_account', $kode_account)
                    ->where('nama_account', $nama_account)->get();
            } else {
                $queryCekAccount = $this->db->table('tbl_account')
                    ->like('kode_account', $kode_account)
                    ->orLike('nama_account', $kode_account)->get();
            }

            $totalData = $queryCekAccount->getNumRows();

            if ($totalData > 1) {
                $msg = [
                    'totaldata' => 'banyak'
                ];
            } else if ($totalData == 1) {
                // insert ke keranjang
                $tkeranjang = $this->db->table('keranjangothrcv');
                $account    = $queryCekAccount->getRowArray();
                $isikeranjang = [
                    'no_bukti'     => $no_random,
                    'kode_account' => $kode_account,
                    'jumlah'       => $jumlah,
                    'keterangan'   => $keterangan
                ];
                $tkeranjang->insert($isikeranjang);
                $msg = ['sukses' => 'berhasil'];
            } else {
                $msg = ['error' => 'Maaf Kode Account ini tidak ditemukan'];
            }
            echo json_encode($msg);
        }
    }


    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_othrcv    = $this->request->getPost('id_othrcv');
            $no_bukti     = $this->request->getPost('no_bukti');
            $kode_account = $this->request->getPost('kode_account');
            $nama_account = $this->request->getPost('nama_account');
            $jumlah       = $this->request->getPost('jumlah');
            $remark       = $this->request->getPost('keterangan');

            $data = [
                'id_othrcv'    => $id_othrcv,
                'no_bukti'     => $no_bukti,
                'kode_account' => $kode_account,
                'nama_account' => $nama_account,
                'jumlah'       => $jumlah,
                'keterangan'   => $remark
            ];

            $msg = [
                'viewmodal' => view('othrcv/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_othrcv   = $this->request->getPost('id_othrcv');
            $no_bukti    = $this->request->getPost('no_bukti');
            $jumlah      = str_replace(',', '', $this->request->getPost('jumlah'));
            $remark      = $this->request->getPost('keterangan');

            $data = array(
                'id_othrcv'   => $id_othrcv,
                'no_bukti'    => $no_bukti,
                'jumlah'      => $jumlah,
                'keterangan'  => $remark
            );
            $this->ModelOthRcv->editCart($data);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $this->ModelOthRcv->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_random    = $this->request->getPost('no_random');
            $no_bukti     = $this->request->getPost('no_bukti');
            $tgl_bukti    = $this->request->getPost('tgl_bukti');
            $kode_account = $this->request->getPost('kode_account');
            $keterangan   = $this->request->getpost('keterangan');
            $no_cheque    = $this->request->getpost('no_cheque');
            $nilai_tukar  = str_replace(',', '', $this->request->getPost('nilai_tukar'));
            $total        = str_replace(',', '', $this->request->getPost('total'));

            $ctr    = $this->ModelCounter->allData();
            $or = $ctr['othrcv'];
            $datactr = [
                'othrcv' => $or
            ];
            $this->ModelCounter->updctr($datactr);
            $ctr    = $this->ModelCounter->allData();
            $nomor  = str_pad(strval(($ctr['othrcv'])), 5, '0', STR_PAD_LEFT);
            $no_bukti  = $nomor . '-OD-' . date('Y');



            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'no_bukti' => [
                    'label' => 'No Voucher',
                    'rules' => 'required|is_unique[tbl_othrcv.no_bukti]',
                    'errors' => [
                        'required'  => '{field} is required',
                        'is_unique' => '{field} already exist'
                    ]
                ],
                'kode_account' => [
                    'label' => 'Account ID',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
             ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNoBukti' => $validation->getError('no_bukti'),
                        'errorKodeAccount' => $validation->getError('kode_account'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $ambildatakeranjang = $this->ModelOthRcv->getCart($no_random);
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Belum diisi transaksi !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $data = [
                        'no_bukti'      => $no_bukti,
                        'tgl_bukti'     => $tgl_bukti,
                        'keterangan'    => $keterangan,  
                        'no_cheque'     => $no_cheque,
                        'kode_account'  => $kode_account,
                        'nilai_tukar'   => $nilai_tukar,
                        'total'         => $total,
                    ];
                    $this->ModelOthRcv->add($data);
                    $ctr = $this->ModelCounter->allData();
                    $oth1 = $ctr['othrcv'] + 1;
                    $datactr = [
                        'othrcv' => $oth1
                    ];
                    $this->ModelCounter->updctr($datactr);


                    foreach ($ambildatakeranjang as $row) :
                        $datarcv = array(
                            'no_bukti'      => $no_bukti,
                            'kode_account'  => $row['kode_account'],
                            'jumlah'        => $row['jumlah'],
                            'keterangan'    => $row['keterangan']
                        );
                        $this->ModelOthRcv->add_detail($datarcv);

                        $codejurnal = "Other Receipt";

                        $data4 = [
                            'no_voucher'     => $no_bukti,
                            'tgl_voucher'    => $tgl_bukti,
                            'kode_account'   => $row['kode_account'],
                            'debet'          => 0,
                            'prime_debet'    => 0,
                            'credit'         => $row['jumlah'] * $nilai_tukar,
                            'prime_credit'   => $row['jumlah'],
                            'keterangan'     => $row['keterangan'],
                            'codejurnal'     => $codejurnal,
                            'rate'           => $nilai_tukar,
                        ];
                        $this->ModelJurnal->add_detail($data4);

                    endforeach;

                    // Insert Jurnal

                    $data2 = [
                        'no_voucher'     => $no_bukti,
                        'tgl_voucher'    => $tgl_bukti,
                        'kode_account'   => $this->request->getPost('kode_account'),
                        'debet'          => $total * $nilai_tukar,
                        'prime_debet'    => $total,
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'keterangan'     => $this->request->getPost('keterangan'),
                        'codejurnal'     => $codejurnal,
                        'rate'           => $nilai_tukar,
                    ];
                    $this->ModelJurnal->add_detail($data2);
                    $this->ModelOthRcv->clearCart($no_random);
                    
                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Penerimaan Kas/Bank : ' . $no_bukti,
                    ];
                    $this->ModelLogHistory->add($datalog);

                    $msg = [
                        'sukses' => 'Other Receipt has been Added !!'
                    ];
                    echo json_encode($msg);
                }
            }
        }
    }

    public function edit($id_bukti)
    {
        $othrcv =  $this->ModelOthRcv->detail($id_bukti);
        $no_bukti = $othrcv['no_bukti'];
        $dothrcv = $this->ModelOthRcv->detail_othrcv($no_bukti);
        $this->ModelOthRcv->clearCart($no_bukti);
        foreach ($dothrcv as $soth) {
            $datakeranjang = array(
                'id_othrcv'    => $soth['id_othrcv'],
                'no_bukti'     => $soth['no_bukti'],
                'kode_account' => $soth['kode_account'],
                'jumlah'       => $soth['jumlah'],
                'keterangan'   => $soth['keterangan']
            );
            $this->ModelOthRcv->addCart($datakeranjang);
        }
        $mothrcv = $this->ModelOthRcv->detail($no_bukti);

        $data = [
            'mothrcv'    => $othrcv,
            'account'    => $this->ModelAccount->allDataBank(),
            'accountall' => $this->ModelAccount->allDataDetail(),
        ];
        return view('othrcv/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $id_bukti     = $this->request->getPost('id_bukti');
            $no_bukti     = $this->request->getPost('no_bukti');
            $tgl_bukti    = $this->request->getPost('tgl_bukti');
            $no_cheque    = $this->request->getPost('no_cheque');
            $kode_account = $this->request->getPost('kode_account');
            $keterangan   = $this->request->getpost('keterangan');
            $total        = str_replace(',', '', $this->request->getPost('total'));
            $nilai_tukar  = str_replace(',', '', $this->request->getPost('nilai_tukar'));

            $data = [
                'id_bukti'      => $id_bukti,
                'no_bukti'      => $no_bukti,
                'tgl_bukti'     => $tgl_bukti,
                'no_cheque'     => $no_cheque,
                'keterangan'    => $keterangan,
                'kode_account'  => $kode_account,
                'total'         => $total,
                'nilai_tukar'   => $nilai_tukar
            ];

            $ambildatakeranjang = $this->ModelOthRcv->getCart($no_bukti);
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Belum diisi transaksi !!!!'
                ];
                echo json_encode($msg);
            } else {
                $this->ModelOthRcv->edit($data);
                $this->ModelOthRcv->delete_detail($no_bukti);
                $this->ModelJurnal->delete_detail($no_bukti);
                $codejurnal = 'Other Receipt';

                foreach ($ambildatakeranjang as $row) :
                    $datapay = array(
                        'no_bukti'      => $row['no_bukti'],
                        'kode_account'  => $row['kode_account'],
                        'jumlah'        => $row['jumlah'],
                        'keterangan'    => $row['keterangan']
                    );
                    $this->ModelOthRcv->add_detail($datapay);

                    $data4 = [
                        'no_voucher'     => $no_bukti,
                        'tgl_voucher'    => $tgl_bukti,
                        'kode_account'   => $row['kode_account'],
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $row['jumlah'],
                        'prime_credit'   => $row['jumlah'] * $nilai_tukar,
                        'keterangan'     => $row['keterangan'],
                        'codejurnal'     => $codejurnal,
                        'rate'           => $nilai_tukar,
                    ];
                    $this->ModelJurnal->add_detail($data4);
                endforeach;

                // Insert Jurnal

                $data2 = [
                    'no_voucher'     => $no_bukti,
                    'tgl_voucher'    => $tgl_bukti,
                    'kode_account'   => $this->request->getPost('kode_account'),
                    'debet'          => $total,
                    'prime_debet'    => $total * $nilai_tukar,
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'keterangan'     => $this->request->getPost('keterangan'),
                    'codejurnal'     => $codejurnal,
                    'rate'           => $nilai_tukar,
                ];
                $this->ModelJurnal->add_detail($data2);
                $this->ModelOthRcv->clearCart($no_bukti);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Penerimaan Kas/Bank : ' . $no_bukti,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Other Receipt has been updated !!!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function detail($id_bukti)
    {
        $mothrcv = $this->ModelOthRcv->detail($id_bukti);
        $no_bukti = $mothrcv['no_bukti'];
        $data = [
            'mothrcv' => $mothrcv,
            'dothrcv' => $this->ModelOthRcv->detail_othrcv($no_bukti),
        ];
        return view('othrcv/v_list', $data);
    }

    public function print($no_bukti)
    {
        $mothrcv = $this->ModelOthRcv->detail($id_bukti);
        $no_bukti = $mothrcv['no_bukti'];
        $data = [
            'mothrcv' => $mothrcv,
            'dothrcv' => $this->ModelOthRcv->detail_othrcv($no_bukti),
        ];
        return view('othrcv/v_print', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nobukti = $this->request->getVar('no_bukti');
            $this->ModelOthRcv->delete_master($nobukti);
            $this->ModelOthRcv->delete_detail($nobukti);
            $this->ModelJurnal->delete_detail($nobukti);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Penerimaan Kas/Bank : ' . $nobukti,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Other Receipt has been deleted !!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
