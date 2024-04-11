<?php

namespace App\Controllers;

use App\Models\ModelUser;
use App\Models\ModelDataUser;

use Config\Services;

class User extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelUser   = new ModelUser();
    }

    public function index()
    {
        $data = [
            'title' => 'Data User',
        ];
        return view('user/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataUser = new ModelDataUser($request);
        if ($request->getMethod(true) == 'POST') {
            $user = $this->ModelDataUser->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($user as $usr) {
                $row = [];
                $row[] = $no++;
                $row[] = $usr['fullname'];
                $row[] = $usr['username'];
                $row[] = $usr['level'];
                $row[] = $usr['foto'];
                $row[] =
                    '<a href="' . base_url('user/edit/' . $usr['username']) . '" class="btn btn-success btn-sm ml-3 mr-2">Edit</a>' .
                    '<a href="' . base_url('user/reset/' . $usr['username']) . '" class="btn btn-primary btn-sm mr-2">Reset Pswrd</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-sm\"  onclick=\"hapusUser('" . $usr['username'] . "') \">Delete</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataUser->count_all(),
                "recordsFiltered" => $this->ModelDataUser->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $data = [
            'title'      => 'Tambah User',
            'level'      => $this->ModelUser->allLevel(),
            'validation'  => \config\Services::validation()
        ];
        return view('user/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $username      = $this->request->getPost('username');
            $fullname      = $this->request->getPost('fullname');
            $level         = $this->request->getPost('level');
            $password      = $this->request->getPost('password');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'fullname' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[tbl_user.username]',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan kode yang lain',
                        'required'  => '{field} tidak boleh kosong'
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
                        'errorUserName'   => $validation->getError('username'),
                        'errorFullName'   => $validation->getError('fullname'),
                        'errorUploadGambar' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {
                // mengambil file foto dari form input
                $foto = $this->request->getFile('uploadgambar');
                // merename nama file foto
                if (@$_FILES['uploadgambar']['name'] != null) {
                    $namafile = $foto->getRandomName();
                } else {
                    $namafile = 'noimage.jpg';
                }
                if (@$_FILES['uploadgambar']['name'] != null) {
                    $foto->move('fotouser', $namafile);
                }

                $data = [
                    'username'   => $username,
                    'fullname'   => $fullname,
                    'password'   => $password,
                    'level'      => $level,
                    'foto'       => $namafile
                ];

                $this->ModelUser->add($data);

                // Update Counter Kategori

                $msg = [
                    'sukses' => 'User Baru Berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($username)
    {
        $data = [
            'user' => $this->ModelUser->detail($username),
            'level'      => $this->ModelUser->allLevel(),
            'validation'  => \config\Services::validation()
        ];

        return view('user/v_edit', $data);
    }

    public function reset($username)
    {
        $data = [
            'username' => $username,
            'password' => $username
        ];
        $this->ModelUser->resetpsw($data);
        // return redirect()->to('/user');
        return redirect()->to(base_url('user'));
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $username      = $this->request->getPost('username');
            $fullname      = $this->request->getPost('fullname');
            $level         = $this->request->getPost('level');
            $validation =  \Config\Services::validation();

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'fullname' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);


            if (!$valid) {
                $msg = [
                    'error' => [

                        'errorFullName'   => $validation->getError('fullname'),

                    ]
                ];
            } else {
                // mengambil foto dari file input
                $foto    = $this->request->getFile('uploadgambar');
                if ($foto->getError() == 4) {
                    //jika foto tidak diganti
                    $data = [
                        'username'   => $username,
                        'fullname'   => $fullname,
                        'level'      => $level,

                    ];
                    $this->ModelUser->edit($data);
                    $msg = [
                        'sukses' => 'Data User Berhasil diupdate'
                    ];
                } else {
                    // Jika Foto diganti
                    // menghapus foto lama
                    $usr = $this->ModelUser->detail($username);
                    if ($usr['foto'] != "noimage.jpg") {
                        unlink('fotouser/' . $usr['foto']);
                    }
                    // merename nama file foto
                    $namafile = $foto->getRandomName();
                    $data = [
                        'username'   => $username,
                        'fullname'   => $fullname,
                        'level'      => $level,
                        'foto'       => $namafile
                    ];
                    $foto->move('fotouser', $namafile);
                    $this->ModelUser->edit($data);
                    $msg = [
                        'sukses' => 'Data User Berhasil diupdate'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('username');
            $user = $this->ModelUser->detail($username);
            if ($user['foto'] != 'noimage.jpg') {
                unlink('fotouser/' . $user['foto']);
            }
            $this->ModelUser->hapus($username);
            $msg = ['sukses' => 'Data User berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_kodeuser()
    {
        $username = $this->request->getPost('username');
        $data = $this->ModelUser->detail($username);
        echo json_encode($data);
    }

    public function changePassword()
    {
        $username = session()->get('username');
        $data = [
            'title' => "Change Password",
            'validation' => \config\Services::validation(),
            'user'  => $this->ModelUser->detail($username),
        ];
        return view('v_changepassword', $data);
    }


public function update_password($username)
    {

        if ($this->validate([
            'new_password1' => [
                'label' => 'New Password',
                'rules' => 'required|matches[new_password2]',
                'errors' => [
                    'required' => '{field} wajib diisi, tidak boleh kosong',
                    'matches' => '{field} harus sama dengan password confirmation',
                ]
            ],

        ])) {


            $user = $this->ModelUser->detail($username);
            $current_password = $this->request->getVar('current_password');
            $new_password = $this->request->getVar('new_password1');
            if ($current_password != $user['password']) {
                session()->setFlashdata('pesan', 'Current Password yang dimasukan salah !!!');
                return redirect()->to(base_url('user/changepassword'));
            } else {
                if ($new_password == $current_password) {
                    session()->setFlashdata('pesan', 'New Password tidak boleh sama dengan Current Password !!!');
                    return redirect()->to(base_url('user/changepassword'));
                } else {
                    $data = [
                        'username'   => $username,
                        'password'  => $this->request->getPost('new_password1'),
                    ];
                    $this->ModelUser->edit($data);
                    return redirect()->to(base_url('admin'));
                }
            }
        } else {
            //jika tidak valid
            $id_user = session()->get('iduser');
            $validation = \config\Services::validation();
            return redirect()->to(base_url('user/changepassword/' . $id_user))->withInput()->with('validation', $validation);
        }
    }

}
