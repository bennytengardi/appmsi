<?php

namespace App\Controllers;

use App\Models\ModelCounter;
use App\Models\ModelDataJurnal;
use App\Models\ModelDataAccount2;
use App\Models\ModelJurnal;
use App\Models\ModelAccount;
use Config\Services;

class Jurnal extends BaseController
{
    public function __construct()
    {
        $this->ModelCounter  = new ModelCounter();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelAccount  = new ModelAccount();
    }

    public function index()
    {
        return view('jurnal/v_index');
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataJurnal = new ModelDataJurnal($request);
        if ($request->getMethod(true) == 'POST') {
            $jurnal = $this->ModelDataJurnal->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($jurnal as $jur) {
                $row = [];
                $row[] = $no++;
                $row[] = $jur['no_voucher'];
                $row[] = date('d-m-Y', strtotime($jur['tgl_voucher']));
                $row[] = number_format($jur['total_debet'], '2', ',', '.');
                $row[] = number_format($jur['total_credit'], '2', ',', '.');
                $row[] = '';
                $row[] =
                    '<a href="' . base_url('jurnal/edit/' . $jur['no_voucher']) . '" class="btn btn-success btn-xs mr-2"></i>Edit</a>' .
                    '<a href="' . base_url('jurnal/detail/' . $jur['no_voucher']) . '" class="btn btn-info btn-xs mr-2"> See Detail</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusJurnal('" . $jur['no_voucher'] . "') \">Delete</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataJurnal->count_all(),
                "recordsFiltered" => $this->ModelDataJurnal->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['jurnal'] + 1)), 5, '0', STR_PAD_LEFT);
        $no_voucher = $nomor . '-JM-' . date('Y');
        $tgl_voucher = date('Y-m-d');
        $data = [
            'no_voucher'   => $no_voucher,
            'tgl_voucher'  => $tgl_voucher,
            'account'    => $this->ModelAccount->allDataDetail(),
            'validation' => \config\Services::validation()
        ];
        $this->ModelJurnal->clearCart();
        return view('jurnal/v_add', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_voucher = $this->request->getPost('no_voucher');
            $dtl  = $this->ModelJurnal->getCart($no_voucher);
            $data  = [
                'datadetail' => $dtl
            ];
            $msg = [
                'data' => view('jurnal/v_harga', $data)
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
                'viewmodal' => view('jurnal/v_cariaccount', $data)
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
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" style=\"height: 26px; font-size: 12px;\"  onclick=\"pilihitem('" . $list['kode_account'] . "','" . $list['nama_account'] . "','" . $list['currency'] . "','" . $list['nilai_tukar'] .  "')\" ><i class=\"fa fa-check\"></i></button>";
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


    public function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            if (empty($this->request->getPost('dbt'))) {
                $dbt = 0;
            } else {
                $dbt = str_replace(',', '', $this->request->getPost('dbt'));
            }
            if (empty($this->request->getPost('crd'))) {
                $crd = 0;
            } else {
                $crd = str_replace(',', '', $this->request->getPost('crd'));
            }
            if (empty($this->request->getPost('prmdb'))) {
                $prmdb = 0;
            } else {
                $prmdb = str_replace(',', '', $this->request->getPost('prmdb'));
            }
            if (empty($this->request->getPost('prmcr'))) {
                $prmcr = 0;
            } else {
                $prmcr = str_replace(',', '', $this->request->getPost('prmcr'));
            }
            if (empty($this->request->getPost('rat'))) {
                $rat = 1;
            } else {
                $rat = str_replace(',', '', $this->request->getPost('rat'));
            }

            $no_voucher   = $this->request->getPost('no_voucher');
            $kode_account = $this->request->getPost('kode_acct');
            $nama_account = $this->request->getPost('nama_acct');
            $keterangan   = $this->request->getPost('ket');
            $rate         = $this->request->getPost('rat');

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
                $tkeranjang = $this->db->table('keranjangjurnal');
                $account    = $queryCekAccount->getRowArray();
                $isikeranjang = [
                    'no_voucher'   => $no_voucher,
                    'kode_account' => $kode_account,
                    'debet'        => $dbt,
                    'credit'       => $crd,
                    'prime_debet'  => $prmdb,
                    'prime_credit' => $prmcr,
                    'rate'         => $rate,
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
            $id_jurnal    = $this->request->getPost('id_jurnal');
            $no_voucher   = $this->request->getPost('no_voucher');
            $kode_account = $this->request->getPost('kode_account');
            $nama_account = $this->request->getPost('nama_account');
            $debet        = $this->request->getPost('debet');
            $credit       = $this->request->getPost('credit');
            $prime_debet  = $this->request->getPost('prime_debet');
            $prime_credit = $this->request->getPost('prime_credit');
            $rate         = $this->request->getPost('rate');
            $remark       = $this->request->getPost('remark');

            $data = [
                'id_jurnal'    => $id_jurnal,
                'no_voucher'   => $no_voucher,
                'kode_account' => $kode_account,
                'nama_account' => $nama_account,
                'debet'        => $debet,
                'credit'       => $credit,
                'prime_debet'  => $prime_debet,
                'prime_credit' => $prime_credit,
                'rate'         => $rate,
                'remark'       => $remark
            ];

            $msg = [
                'viewmodal' => view('jurnal/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_jurnal   = $this->request->getPost('id_jurnal');
            $no_voucher  = $this->request->getPost('no_voucher');
            $debet       = str_replace(',', '', $this->request->getPost('debet'));
            $credit      = str_replace(',', '', $this->request->getPost('credit'));
            $rate        = str_replace(',', '', $this->request->getPost('rate'));
            $remark      = $this->request->getPost('remark');

            $data = array(
                'id_jurnal'   => $id_jurnal,
                'no_voucher'  => $no_voucher,
                'debet'       => $debet,
                'credit'      => $credit,
                'rate'        => $rate,
                'prime_debet'  => $debet / $rate,
                'prime_credit' => $credit / $rate,
                'keterangan'  => $remark
            );
            $this->ModelJurnal->editCart($data);

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
            $this->ModelJurnal->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_voucher   = $this->request->getPost('no_voucher');
            $tgl_voucher  = $this->request->getPost('tgl_voucher');
            $totaldebet   = str_replace(',', '', $this->request->getPost('total_debet'));
            $totalcredit  = str_replace(',', '', $this->request->getPost('total_credit'));
            
            $data = [
                'no_voucher'   => $no_voucher,
                'tgl_voucher'  => $tgl_voucher,
                'total_debet'  => $totaldebet,
                'total_credit' => $totalcredit,
            ];

            $ambildatakeranjang = $this->ModelJurnal->ambilDataCart();
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Belum diisi transaksi !!!!'
                ];
                echo json_encode($msg);
            } else {

                $this->ModelJurnal->add_header($data);

                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['jurnal'] + 1;
                $datactr = [
                    'jurnal' => $inv
                ];
                $this->ModelCounter->updctr($datactr);
                $codejurnal = 'Memorial';

                foreach ($ambildatakeranjang as $row) :
                    $datajurnal = array(
                        'no_voucher'    => $row['no_voucher'],
                        'tgl_voucher'   => $tgl_voucher,
                        'kode_account'  => $row['kode_account'],
                        'debet'         => $row['debet'],
                        'credit'        => $row['credit'],
                        'prime_debet'   => $row['prime_debet'],
                        'prime_credit'  => $row['prime_credit'],
                        'rate'          => $row['rate'],
                        'keterangan'    => $row['keterangan'],
                        'codejurnal'    => 'Memorial',
                    );
                    $this->ModelJurnal->add_detail($datajurnal);
                endforeach;

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Jurnal Memorial : ' . $no_voucher,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Journal Memorial has been Added !!!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function edit($no_voucher)
    {
        $djurnal = $this->ModelJurnal->get_djurnal($no_voucher);
        $this->ModelJurnal->clearCart();
        foreach ($djurnal as $djur) {
            $datakeranjang = array(
                'no_voucher'   => $djur['no_voucher'],
                'kode_account' => $djur['kode_account'],
                'debet'        => $djur['debet'],
                'credit'       => $djur['credit'],
                'prime_debet'  => $djur['prime_debet'],
                'prime_credit' => $djur['prime_credit'],
                'rate'         => $djur['rate'],
                'keterangan'   => $djur['keterangan']
            );
            $this->ModelJurnal->addCart($datakeranjang);
        }
        $mjurnal = $this->ModelJurnal->get_jurnal($no_voucher);

        $data = [
            'mjurnal'    => $mjurnal,
            'account'    => $this->ModelAccount->allDataDetail(),
        ];
        return view('jurnal/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $no_voucher   = $this->request->getPost('no_voucher');
            $tgl_voucher  = $this->request->getPost('tgl_voucher');
            $totaldebet   = str_replace(',', '', $this->request->getPost('total_debet'));
            $totalcredit  = str_replace(',', '', $this->request->getPost('total_credit'));

            $data = [
                'no_voucher'   => $no_voucher,
                'tgl_voucher'  => $tgl_voucher,
                'total_debet'  => $totaldebet,
                'total_credit' => $totalcredit,
            ];
            $ambildatakeranjang = $this->ModelJurnal->ambilDataCart();
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Belum diisi transaksi !!!!'
                ];
                echo json_encode($msg);
            } else {
                $this->ModelJurnal->edit($data);
                $this->ModelJurnal->delete_detail($no_voucher);
                $codejurnal = 'Memorial';

                foreach ($ambildatakeranjang as $row) :
                    $datajurnal = array(
                        'no_voucher'    => $row['no_voucher'],
                        'tgl_voucher'   => $tgl_voucher,
                        'kode_account'  => $row['kode_account'],
                        'debet'         => $row['debet'],
                        'credit'        => $row['credit'],
                        'prime_debet'   => $row['prime_debet'],
                        'prime_credit'  => $row['prime_credit'],
                        'rate'          => $row['rate'],
                        'keterangan'    => $row['keterangan'],
                        'codejurnal'    => $codejurnal,
                    );
                    $this->ModelJurnal->add_detail($datajurnal);
                endforeach;

                $this->ModelJurnal->clearCart();

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Jurnal Memorial : ' . $no_voucher,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Jurnal Memorial has been Updated'
                ];
                echo json_encode($msg);
            }
        }
    }


    public function detail($no_voucher)
    {
        $data = [
            'mjurnal' => $this->ModelJurnal->get_jurnal($no_voucher),
            'djurnal' => $this->ModelJurnal->get_djurnal($no_voucher)
        ];
        return view('jurnal/v_list', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $novoucher = $this->request->getVar('no_voucher');
            $this->ModelJurnal->delete_master($novoucher);
            $this->ModelJurnal->delete_detail($novoucher);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Jurnal Memorial : ' . $novoucher,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Data Jurnal Memorial berhasil dihapus'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
    
    public function cekBalance()
    {
        $dari   = date("2023-03-01");
        $sampai = date("2023-03-31");
        $djurnal = $this->ModelJurnal->get_alljurnal($dari,$sampai);
        dd($djurnal);
        $data = [
            'djurnal' => $djurnal
        ];
        // return view('jurnal/v_balance', $data);
    }
    
}
