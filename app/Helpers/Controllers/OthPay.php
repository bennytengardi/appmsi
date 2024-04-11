<?php

namespace App\Controllers;

use App\Models\ModelOthPay;
use App\Models\ModelDataOthPay;
use App\Models\ModelDataAccount2;
use App\Models\ModelJurnal;
use App\Models\ModelAccount;
use App\Models\ModelDivisi;
use App\Models\ModelCounter;
use App\Models\ModelLogHistory;
use Config\Services;

class OthPay extends BaseController
{
    public function __construct()
    {
        $this->ModelOthPay   = new ModelOthPay();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelAccount  = new ModelAccount();
        $this->ModelDivisi   = new ModelDivisi();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlothpay', $date);
        session()->set('tglakhothpay', date('Y-m-d'));
        session()->set('acct1', 'ALL');
        $data = [
            'account'    => $this->ModelAccount->allDataBank(),
        ];
        return view('othpay/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataOthPay = new ModelDataOthPay($request);
        if ($request->getMethod(true) == 'POST') {
            $othpay = $this->ModelDataOthPay->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($othpay as $cr) {
                $row = [];
                $row[] = $no++;
                $row[] = $cr['no_bukti'];
                $row[] = date('d-m-Y', strtotime($cr['tgl_bukti']));
                $row[] = $cr['nama_account'];
                $row[] = $cr['kode_divisi'];
                $row[] = number_format($cr['total'], '2', ',', '.');
                $row[] = $cr['currency'];
                $row[] = $cr['keterangan'];
                $row[] =
                    '<a href="' . base_url('OthPay/edit/' . $cr['id_bukti']) . '" class="btn btn-success btn-xs mr-2"><i class="fa fa-edit"></i> Edit</a>' .
                    '<a href="' . base_url('OthPay/detail/' . $cr['id_bukti']) . '" class="btn btn-info btn-xs mr-2"><i class="fa fa-eye"></i> Detail</a>' .
                    '<a href="' . base_url('OthPay/print/' . $cr['id_bukti']) . '" class="btn btn-primary btn-xs mr-2"><i class="fa fa-print"></i> Print</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusOthPay('" . $cr['id_bukti'] . "','" . $cr['no_bukti'] . "') \"><i class='fa fa-trash-alt'></i> Delete</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataOthPay->count_all(),
                "recordsFiltered" => $this->ModelDataOthPay->count_filtered(),
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
        $nomor  = str_pad(strval(($ctr['othpay'])), 5, '0', STR_PAD_LEFT);
        $no_bukti  = $nomor . '-OP-' . date('Y');
        $tgl_bukti = date('Y-m-d');
        $data = [
            'no_bukti'   => $no_bukti,
            'no_random'  => $no_random,
            'tgl_bukti'  => $tgl_bukti,
            'divisi'     => $this->ModelDivisi->allData(),
            'account'    => $this->ModelAccount->allDataBank(),
            'accountall' => $this->ModelAccount->allDataDetail(),
            'validation' => \config\Services::validation()
        ];
        $this->ModelOthPay->clearCart($no_random);
        return view('othpay/v_add', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_bukti = $this->request->getPost('no_bukti');
            $dtl      = $this->ModelOthPay->getCart($no_bukti);
            $data  = [
                'datadetail' => $dtl
            ];
            $msg = [
                'data' => view('othpay/v_harga', $data)
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
                'viewmodal' => view('othpay/v_cariaccount', $data)
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
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" style=\"height: 26px; font-size: 12px;\"  onclick=\"pilihitem('" . $list['kode_account'] . "','" . $list['nama_account'] . "')\" ><i class=\"fa fa-check\"></i></button>";
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

            session()->set('tglawlothpay', $tgl1);
            session()->set('tglakhothpay', $tgl2);
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
                $tkeranjang = $this->db->table('keranjangothpay');
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
            $id_othpay    = $this->request->getPost('id_othpay');
            $no_bukti     = $this->request->getPost('no_bukti');
            $kode_account = $this->request->getPost('kode_account');
            $nama_account = $this->request->getPost('nama_account');
            $jumlah       = $this->request->getPost('jumlah');
            $remark       = $this->request->getPost('keterangan');

            $data = [
                'id_othpay'    => $id_othpay,
                'no_bukti'     => $no_bukti,
                'kode_account' => $kode_account,
                'nama_account' => $nama_account,
                'jumlah'       => $jumlah,
                'keterangan'   => $remark
            ];

            $msg = [
                'viewmodal' => view('othpay/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_othpay   = $this->request->getPost('id_othpay');
            $no_bukti    = $this->request->getPost('no_bukti');
            $jumlah      = str_replace(',', '', $this->request->getPost('jumlah'));
            $remark      = $this->request->getPost('keterangan');

            $data = array(
                'id_othpay'   => $id_othpay,
                'no_bukti'    => $no_bukti,
                'jumlah'      => $jumlah,
                'keterangan'  => $remark
            );
            $this->ModelOthPay->editCart($data);
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
            $this->ModelOthPay->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_bukti     = $this->request->getPost('no_bukti');
            $no_random    = $this->request->getPost('no_random');
            $tgl_bukti    = $this->request->getPost('tgl_bukti');
            $kode_account = $this->request->getPost('kode_account');
            $kepada       = $this->request->getPost('kepada');
            $no_cheque    = $this->request->getPost('no_cheque');
            $keterangan   = $this->request->getpost('keterangan');
            $kode_divisi  = $this->request->getPost('kode_divisi');
            $nilai_tukar  = str_replace(',', '', $this->request->getPost('nilai_tukar'));
            $total        = str_replace(',', '', $this->request->getPost('total'));

            $ctr    = $this->ModelCounter->allData();
            $op = $ctr['othpay'];
            $datactr = [
                'othpay' => $op
            ];
            $this->ModelCounter->updctr($datactr);
            $ctr    = $this->ModelCounter->allData();
            $nomor  = str_pad(strval(($ctr['othpay'])), 5, '0', STR_PAD_LEFT);
            $no_bukti  = $nomor . '-OP-' . date('Y');

            $validation   =  \Config\Services::validation();

            $valid = $this->validate([
                'no_bukti' => [
                    'label' => 'No Voucher',
                    'rules' => 'required|is_unique[tbl_othpay.no_bukti]',
                    'errors' => [
                        'required'  => '{field} is required',
                        'is_unique' => '{field} already exist'
                    ]
                ],
                'kode_account' => [
                    'label' => 'No Account',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_divisi' => [
                    'label' => 'Kode Divisi',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is requeired'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNoBukti' => $validation->getError('no_bukti'),
                        'errorKodeAccount' => $validation->getError('kode_account'),
                        'errorKodeDivisi' => $validation->getError('kode_divisi'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $ambildatakeranjang = $this->ModelOthPay->getCart($no_random);
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Belum diisi transaksi !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $data = [
                        'no_bukti'      => $no_bukti,
                        'tgl_bukti'     => $tgl_bukti,
                        'kepada'        => $kepada,
                        'no_cheque'     => $no_cheque,
                        'keterangan'    => $keterangan,
                        'kode_account'  => $kode_account,
                        'kode_divisi'   => $kode_divisi,
                        'nilai_tukar'   => $nilai_tukar,
                        'total'         => $total,
                    ];
                    $this->ModelOthPay->add($data);

                    $ctr = $this->ModelCounter->allData();
                    $oth = $ctr['othpay'] + 1;
                    $datactr = [
                        'othpay' => $oth
                    ];
                    $this->ModelCounter->updctr($datactr);


                    foreach ($ambildatakeranjang as $row) :
                        $datapay = array(
                            'no_bukti'      => $no_bukti,
                            'kode_account'  => $row['kode_account'],
                            'jumlah'        => $row['jumlah'],
                            'keterangan'    => $row['keterangan']
                        );
                        $this->ModelOthPay->add_detail($datapay);

                        $codejurnal = "Other Payment";

                        $data4 = [
                            'no_voucher'     => $no_bukti,
                            'tgl_voucher'    => $tgl_bukti,
                            'kode_account'   => $row['kode_account'],
                            'credit'         => 0,
                            'prime_credit'   => 0,
                            'debet'          => $row['jumlah'] * $nilai_tukar,
                            'prime_debet'    => $row['jumlah'],
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
                        'credit'         => $total * $nilai_tukar,
                        'prime_credit'   => $total,
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'keterangan'     => $this->request->getPost('keterangan'),
                        'codejurnal'     => $codejurnal,
                        'rate'           => $nilai_tukar,
                    ];
                    $this->ModelJurnal->add_detail($data2);
                    $this->ModelOthPay->clearCart($no_random);

                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Pengeluaran Kas/Bank : ' . $no_bukti,
                    ];
                    $this->ModelLogHistory->add($datalog);

                    $msg = [
                        'sukses' => 'Other Payment has been Added !!'
                    ];
                    echo json_encode($msg);
                }
            }
        }
    }

    public function edit($id_bukti)
    {
        $othpay   = $this->ModelOthPay->detail($id_bukti);
        $no_bukti = $othpay['no_bukti'];
        $dothpay  = $this->ModelOthPay->detail_othpay($no_bukti);
        $this->ModelOthPay->clearCart($no_bukti);

        foreach ($dothpay as $soth) {
            $datakeranjang = array(
                'id_othpay'    => $soth['id_othpay'],
                'no_bukti'     => $soth['no_bukti'],
                'kode_account' => $soth['kode_account'],
                'jumlah'       => $soth['jumlah'],
                'keterangan'   => $soth['keterangan']
            );
            $this->ModelOthPay->addCart($datakeranjang);
        }

        $data = [
            'mothpay'    => $othpay,
            'account'    => $this->ModelAccount->allDataBank(),
            'accountall' => $this->ModelAccount->allDataDetail(),
            'divisi'     => $this->ModelDivisi->allData(),
        ];
        return view('othpay/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $id_bukti     = $this->request->getPost('id_bukti');
            $no_bukti     = $this->request->getPost('no_bukti');
            $tgl_bukti    = $this->request->getPost('tgl_bukti');
            $no_cheque    = $this->request->getPost('no_cheque');
            $kode_divisi  = $this->request->getPost('kode_divisi');
            $kode_account = $this->request->getPost('kode_account');
            $kepada       = $this->request->getPost('kepada');
            $keterangan   = $this->request->getpost('keterangan');
            $total        = str_replace(',', '', $this->request->getPost('total'));
            $nilai_tukar  = str_replace(',', '', $this->request->getPost('nilai_tukar'));

            $data = [
                'id_bukti'      => $id_bukti,
                'no_bukti'      => $no_bukti,
                'tgl_bukti'     => $tgl_bukti,
                'no_cheque'     => $no_cheque,
                'kode_divisi'   => $kode_divisi,
                'kepada'        => $kepada,
                'keterangan'    => $keterangan,
                'kode_account'  => $kode_account,
                'total'         => $total,
                'nilai_tukar'   => $nilai_tukar
            ];

            $ambildatakeranjang = $this->ModelOthPay->getCart($no_bukti);
            
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Belum diisi transaksi !!!!'
                ];
                echo json_encode($msg);
            } else {
                $this->ModelOthPay->edit($data);
                $this->ModelOthPay->delete_detail($no_bukti);
                $this->ModelJurnal->delete_detail($no_bukti);
                $codejurnal = 'Other Payment';
                foreach ($ambildatakeranjang as $row) :
                    $datapay = array(
                        'no_bukti'      => $row['no_bukti'],
                        'kode_account'  => $row['kode_account'],
                        'jumlah'        => $row['jumlah'],
                        'keterangan'    => $row['keterangan']
                    );
                    $this->ModelOthPay->add_detail($datapay);

                    $data4 = [
                        'no_voucher'     => $no_bukti,
                        'tgl_voucher'    => $tgl_bukti,
                        'kode_account'   => $row['kode_account'],
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'debet'          => $row['jumlah'] * $nilai_tukar,
                        'prime_debet'    => $row['jumlah'],
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
                    'credit'         => $total * $nilai_tukar,
                    'prime_credit'   => $total,
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'keterangan'     => $this->request->getPost('keterangan'),
                    'codejurnal'     => $codejurnal,
                    'rate'           => $nilai_tukar,
                ];
                $this->ModelJurnal->add_detail($data2);
                $this->ModelOthPay->clearCart($no_bukti);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Pengeluaran Kas/Bank : ' . $no_bukti,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Other Payment has been updated !!!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function detail($id_bukti)
    {
        $mothpay   = $this->ModelOthPay->detail($id_bukti);
        $no_bukti  = $mothpay['no_bukti'];
        $data = [
            'mothpay' => $mothpay,
            'dothpay' => $this->ModelOthPay->detail_othpay($no_bukti),
        ];
        return view('othpay/v_list', $data);
    }

    public function print($id_bukti)
    {
        $mothpay   = $this->ModelOthPay->detail($id_bukti);
        $no_bukti  = $mothpay['no_bukti'];
        $data = [
            'mothpay' => $mothpay,
            'dothpay' => $this->ModelOthPay->detail_othpay($no_bukti),
        ];
        return view('othpay/v_print', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nobukti = $this->request->getVar('no_bukti');
            $this->ModelOthPay->delete_master($nobukti);
            $this->ModelOthPay->delete_detail($nobukti);
            $this->ModelJurnal->delete_detail($nobukti);
            
                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menghapus Pengeluaran Kas/Bank : ' . $nobukti,
                    ];
                    $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Other Payment been deleted !!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
