<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelDataBarang;
use App\Models\ModelDataBaku2;
use App\Models\ModelMerk;
use App\Models\ModelCurrency;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;
use App\Models\ModelCounter;
use App\Models\ModelLogHistory;

use Config\Services;

class Barang extends BaseController
{
    public function __construct()
    {
        $this->ModelBarang   = new ModelBarang();
        $this->ModelKategori = new ModelKategori();
        $this->ModelSatuan   = new ModelSatuan();
        $this->ModelMerk     = new ModelMerk();
        $this->ModelCurrency = new ModelCurrency();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        session()->set('mrk1', 'ALL');
        session()->set('kat1', 'ALL');
        $data = [
            'title' => 'Barang Jadi',
            'merk'=> $this->ModelMerk->allData(),
            'kategori'=> $this->ModelKategori->allData(),
        ];
        return view('barang/v_index', $data);
    }

    public function index2()
    {
        $data = [
            'title' => 'Barang Jadi',
            'merk'=> $this->ModelMerk->allData(),
            'kategori'=> $this->ModelKategori->allData(),
        ];
        return view('barang/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataBarang = new ModelDataBarang($request);
        if ($request->getMethod(true) == 'POST') {
            $barang = $this->ModelDataBarang->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($barang as $brg) {
                $row = [];
                $row[] = $no++;
                $row[] = $brg['kode_barang'];
                $row[] = $brg['nama_barang'];
                $row[] = $brg['nama_kategori'];
                $row[] = $brg['kode_merk'];
                $row[] = $brg['kode_satuan'];
                $row[] = number_format($brg['hargajual'], 0, '.', ',');
                $row[] = number_format($brg['hargabeli'], 2, '.', ',');
                $row[] = $brg['currency'];
                $row[] = number_format($brg['awal'] + $brg['masuk'] + $brg['returjual'] - $brg['keluar'] - $brg['returbeli'] + $brg['adjust'], 0, '.', ',');                
                $row[] =
                    '<a href="' . base_url('barang/edit/' . $brg['id_barang']) . '" class="btn btn-success btn-xs mr-2" style="height:18px;font-size: 10px;">EDIT</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" style=\"height:18px;font-size: 10px;\" onclick=\"hapusBarang('" . $brg['id_barang'] .  "',`" . $brg['nama_barang'] . "`) \" >DELETE</button>";            
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataBarang->count_all(),
                "recordsFiltered" => $this->ModelDataBarang->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $ctr = $this->ModelCounter->allData();
        $data = [
            'title'       => 'Tambah Barang',
            'kategori'    => $this->ModelKategori->allData(),
            'merk'        => $this->ModelMerk->allData(),
            'currency'    => $this->ModelCurrency->allData(),
            'validation'  => \config\Services::validation()
        ];

        return view('barang/v_add', $data);
    }

    public function ambilDataSatuan()
    {
        if ($this->request->isAJAX()) {
            $datasatuan = $this->ModelSatuan->allData();
            $isidata = "<option value='' selected>Pilih Satuan</option>";
            // $isidata = "<option value='PCS' selected>PCS</option>";
            foreach ($datasatuan as $row) :
                $isidata .= '<option value="' . $row['kode_satuan'] . '">' . $row['kode_satuan'] . ' </option>';
            endforeach;
            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }

    public function ambilDataMerk()
    {
        if ($this->request->isAJAX()) {
            $datamerk = $this->ModelMerk->allData();
            $isidata = "<option value='' selected>Pilih Merk</option>";
            // $isidata = "<option value='FRANKLIN' selected>FRANKLIN</option>";
            foreach ($datamerk as $row) :
                $isidata .= '<option value="' . $row['kode_merk'] . '">' . $row['kode_merk'] . ' </option>';
            endforeach;
            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }

    public function ambilDataKategori()
    {
        if ($this->request->isAJAX()) {
            $datakategori = $this->ModelKategori->allData();
            $isidata = "<option value='' selected>Pilih Kategori</option>";
            // $isidata = "<option value='POMPA' selected>POMPA</option>";
            foreach ($datakategori as $row) :
                $isidata .= '<option value="' . $row['kode_kategori'] . '">' . $row['kode_kategori'] . ' </option>';
            endforeach;
            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }
    
    public function setses()
    {
        if ($this->request->isAJAX()) {
            $mrk1 = $this->request->getPost('mrk');
            $kat1 = $this->request->getPost('kat');
            session()->set('mrk1', $mrk1);
            session()->set('kat1', $kat1);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_barang   = str_replace('"',"'",$this->request->getPost('kode_barang'));
            $nama_barang   = str_replace('"',"'",$this->request->getPost('nama_barang'));
            $kode_kategori = $this->request->getPost('kode_kategori');
            $kode_merk     = $this->request->getPost('kode_merk');
            $kode_satuan   = $this->request->getPost('kode_satuan');
            $sttstok       = $this->request->getPost('sttstok');
            $hargajual     = str_replace(',', '', $this->request->getPost('hargajual'));
            $hargabeli     = str_replace(',', '', $this->request->getPost('hargabeli'));
            $currency      = $this->request->getPost('currency');
            $nilaikurs     = str_replace(',','', $this->request->getPost('nilaikurs'));
            $description   = $this->request->getPost('description');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_barang' => [
                    'label' => 'Item No',
                    'rules' => 'required|is_unique[tbl_barang.kode_barang]',
                    'errors' => [
                        'required'  => '{field} is required',
                        'is_unique' => '{field} already exist'
                    ]
                ],
                'nama_barang' => [
                    'label' => 'Item Name',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_kategori' => [
                    'label' => 'Category',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_merk' => [
                    'label' => 'Merk',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_satuan' => [
                    'label' => 'Unit',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],

                'uploadgambar' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[uploadgambar,image/png,image/jpg,image/jpeg]|ext_in[uploadgambar,png,jpg,jpeg]|is_image[uploadgambar]',
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeBarang'   => $validation->getError('kode_barang'),
                        'errorNamaBarang'   => $validation->getError('nama_barang'),
                        'errorKodeKategori' => $validation->getError('kode_kategori'),
                        'errorKodeMerk'     => $validation->getError('kode_merk'),
                        'errorKodeSatuan'   => $validation->getError('kode_satuan'),
                        'errorUploadGambar' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {
                $foto = $this->request->getFile('uploadgambar');
                if (@$_FILES['uploadgambar']['name'] != null) {
                    $namafile = $foto->getRandomName();
                } else {
                    $namafile = 'noimage.jpg';
                }
                if (@$_FILES['uploadgambar']['name'] != null) {
                    $foto->move('fotoproduk', $namafile);
                }

                $data = [
                    'kode_barang'   => $kode_barang,
                    'nama_barang'   => $nama_barang,
                    'kode_kategori' => $kode_kategori,
                    'kode_merk'     => $kode_merk,
                    'kode_satuan'   => $kode_satuan,
                    'sttstok'       => $sttstok,
                    'hargajual'     => $hargajual,
                    'hargabeli'     => $hargabeli,
                    'currency'      => $currency,
                    'nilaikurs'     => $nilaikurs,
                    'description'   => $description,
                    'gambar'        => $namafile
                ];
                $this->ModelBarang->add($data);

                // Update Counter

                // $ctr = $this->ModelCounter->allData();
                // $inv = $ctr['barang'] + 1;
                // $data = [
                //     'barang' => $inv
                // ];
                // $this->ModelCounter->updctr($data);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Barang : ' . $nama_barang,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Item has been added successfully'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($id_barang)
    {
        $data = [
            'barang'     => $this->ModelBarang->detail($id_barang),
            'satuan'     => $this->ModelSatuan->allData(),
            'merk'       => $this->ModelMerk->allData(),
            'currency'   => $this->ModelCurrency->allData(),
            'kategori'   => $this->ModelKategori->allData(),
            'validation' => \config\Services::validation()
        ];
        
        return view('barang/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $id_barang   = $this->request->getPost('id_barang');
            $kode_barang   = str_replace('"',"'",$this->request->getPost('kode_barang'));
            $nama_barang   = str_replace('"',"'",$this->request->getPost('nama_barang'));
            $kode_kategori = $this->request->getPost('kode_kategori');
            $kode_merk     = $this->request->getPost('kode_merk');
            $kode_satuan   = $this->request->getPost('kode_satuan');
            $sttstok       = $this->request->getPost('sttstok');
            $hargajual     = str_replace(',', '', $this->request->getPost('hargajual'));
            $hargabeli     = str_replace(',', '', $this->request->getPost('hargabeli'));
            $currency      = $this->request->getPost('currency');
            $nilaikurs     = str_replace(',','',$this->request->getPost('nilaikurs'));
            $description   = $this->request->getPost('description');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_barang' => [
                    'label' => 'Item No',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'nama_barang' => [
                    'label' => 'Item Name',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_kategori' => [
                    'label' => 'Category',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_merk' => [
                    'label' => 'Merk',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_satuan' => [
                    'label' => 'Unit',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],

                'uploadgambar' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[uploadgambar,image/png,image/jpg,image/jpeg]|ext_in[uploadgambar,png,jpg,jpeg]|is_image[uploadgambar]',
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeBarang'   => $validation->getError('kode_barang'),
                        'errorNamaBarang'   => $validation->getError('nama_barang'),
                        'errorKodeKategori' => $validation->getError('kode_kategori'),
                        'errorKodeMerk'     => $validation->getError('kode_merk'),
                        'errorKodeSatuan'   => $validation->getError('kode_satuan'),
                        'errorUploadGambar' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {
                // mengambil foto dari file input
                $foto    = $this->request->getFile('uploadgambar');
                if ($foto->getError() == 4) {
                    //jika foto tidak diganti
                    $data = [
                        'id_barang'     => $id_barang,
                        'kode_barang'   => $kode_barang,
                        'nama_barang'   => $nama_barang,
                        'kode_kategori' => $kode_kategori,
                        'kode_merk'     => $kode_merk,
                        'kode_satuan'   => $kode_satuan,
                        'sttstok'       => $sttstok,
                        'hargajual'     => $hargajual,
                        'hargabeli'     => $hargabeli,
                        'currency'      => $currency,
                        'nilaikurs'     => $nilaikurs,
                        'description'   => $description,
                    ];
                    $this->ModelBarang->edit($data);
                    $msg = [
                        'sukses' => 'Item has been updated successfully'
                    ];
                } else {
                    // Jika Foto diganti
                    // menghapus foto lama
                    $brg = $this->ModelBarang->detail($kode_barang);
                    if ($brg['gambar'] != "noimage.jpg") {
                        unlink('fotoproduk/' . $brg['gambar']);
                    }
                    // merename nama file foto
                    $namafile = $foto->getRandomName();
                    $data = [
                        'id_barang'     => $id_barang,
                        'kode_barang'   => $kode_barang,
                        'nama_barang'   => $nama_barang,
                        'kode_kategori' => $kode_kategori,
                        'kode_merk'     => $kode_merk,
                        'kode_satuan'   => $kode_satuan,
                        'sttstok'       => $sttstok,
                        'hargajual'     => $hargajual,
                        'hargabeli'     => $hargabeli,
                        'currency'      => $currency,
                        'nilaikurs'     => $nilaikurs,
                        'description'   => $description,
                        'gambar'        => $namafile
                    ];
                    $foto->move('fotoproduk', $namafile);
                    $this->ModelBarang->edit($data);

                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Merubah Tabel Barang : ' . $nama_barang,
                    ];
                    $this->ModelLogHistory->add($datalog);

                    $msg = [
                        'sukses' => 'Item has been updated successfully'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_barang = $this->request->getVar('id_barang');
            $barang = $this->ModelBarang->detail($id_barang);
            $this->ModelBarang->hapus($id_barang);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Tabel Barang : ' . $barang['nama_barang'],
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = [
                'sukses' => 'Item has been Deleted successfully'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_idbarang()
    {
        $id = $this->request->getPost('id_barang');
        $data = $this->ModelBarang->detail($id);
        if ($data) {
            echo json_encode($data);
        } else {
            $msg = 'Data Barang berhasil dihapus !!!';
            echo json_encode($msg);
        }
    }

    public function cari_kodebarang()
    {
        $kode = $this->request->getPost('kode_barang');
        $data = $this->ModelBarang->detail2($kode);
        if ($data) {
            echo json_encode($data);
        } else {
            $msg = 'Data Barang berhasil dihapus !!!';
            echo json_encode($msg);
        }
    }

    public function cari_history()
    {
        $kode_barang = $this->request->getPost('kode_barang');
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelBarang->detail_history($kode_barang, $kode_customer);
        echo json_encode($data);
    }

    public function getDataAutoComplete()
    {
        $autocomplete = $this->request->getVar('term');
        if ($autocomplete) {
            $getDataAutoComplete = $this->ModelBarang->getDataAutoComplete($autocomplete);
            foreach ($getDataAutoComplete as $row) {
                $results[] = array(
                    'label' => $row['nama_barang']
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($results));
            }
        }
    }
    
    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getPost('search');
            $databarang = $this->ModelBarang->caribarang($search);
            foreach ($databarang as $row) :
                $list[]= [
                  'id' => $row['kode_barang'],
                  'text' => $row['nama_barang'],
                ];
            endforeach;
            echo json_encode($list);
        }
    }
    

    public function cari_kodebarang2()
    {
        $kode_barang = $this->request->getPost('kode_barang');
        $data = $this->ModelBarang->detail2($kode_barang);
        echo json_encode($data);
    }
}
