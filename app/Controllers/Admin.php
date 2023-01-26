<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use App\Controllers\AESCTR;
// use App\Controllers\TestingAES;

class Admin extends BaseController
{
    private $penggunaModel;
    private $AES;
    // private $testingAES;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
        $this->AES = new AESCTR();
        $this->key = '105216050ILMUKOMPUTER';
        $this->bit = 256;

        // $key = '313035323136303530494c4d554b4f4d50555445522020202020202020202020';
        // $this->testingAES = new TestingAES(hex2bin($key), 'ECB');
    }

    public function index()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'nama' => session()->get('nama')
        ];

        return view('admin/dashboard', $data);
    }

    public function daftar_pengguna()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $no = 1;

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'daftarPengguna' => $this->penggunaModel->list_pengguna(),
            'list_peran' => $this->penggunaModel->list_peran(),
            'divisi' => $this->penggunaModel->list_divisi(),
            'no' => $no,
            'validation' => \Config\Services::validation(),
            'peran' => 0,
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('admin/daftar_pengguna_page', $data);
    }

    public function tambah_pengguna()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|trim|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'The Nama field is required.',
                    'min_length[3]' => 'The Nama field must be at least 6 characters in length.',
                    'max_length[50]' => 'The Nama field cannot exceed 50 characters in length.'
                ]
            ],
            'email' => [
                'rules' => 'required|trim|valid_email|is_unique[pengguna.email]',
                'errors' => [
                    'required' => 'The Email field is required.',
                    'valid_email' => 'The Email field must contain a valid email address.',
                    'is_unique' => 'Your Email has already been registered.',
                ]
            ],
            'password' => [
                'rules' => 'required|trim|min_length[6]',
                'errors' => [
                    'required' => 'The Password field is required.',
                    'min_length[3]' => 'The Password field must be at least 6 characters in length.'
                ]
            ]
        ])) {

            $validation =  session()->setFlashdata('pesan_error', \Config\Services::validation()->listErrors());
            return redirect()->to('/admin/daftar_pengguna')->withInput()->with('validation', $validation);
        }

        $this->penggunaModel->save([
            'nama' => $this->request->getVar('nama'),
            'email' => $this->AES->encrypt($this->request->getVar('email'), $this->key, $this->bit),
            'password' => $this->AES->encrypt($this->request->getVar('password'), $this->key, $this->bit),
            'role_id' => $this->request->getVar('role_id'),
            'divisi_id' => $this->request->getVar('divisi_id')
        ]);

        session()->setFlashdata('pesan_pengguna', 'Pengguna Berhasil Ditambahkan.');

        return redirect()->to('/admin/daftar_pengguna');
    }

    public function edit_pengguna($id)
    {
        // cek email
        /*
        $email_lama = $this->penggunaModel->list_pengguna($this->request->getVar('id'));
        if ($email_lama['email'] == $this->request->getVar('email')) {
            $rule_email = 'required|trim|valid_email';
        } else {
            $rule_email = 'required|trim|valid_email|is_unique[pengguna.email]';
        }
        */

        if (!$this->validate([
            'nama' => [
                'rules' => 'required|trim|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'The Nama field is required.',
                    'min_length[3]' => 'The Nama field must be at least 6 characters in length.',
                    'max_length[50]' => 'The Nama field cannot exceed 50 characters in length.'
                ]
            ],
            'email' => [
                'rules' => 'required|trim|valid_email',
                'errors' => [
                    'required' => 'The Email field is required.',
                    'valid_email' => 'The Email field must contain a valid email address.',
                    'is_unique' => 'Your Email has already been registered.',
                ]
            ],
            'password' => [
                'rules' => 'required|trim|min_length[6]',
                'errors' => [
                    'required' => 'The Password field is required.',
                    'min_length[3]' => 'The Password field must be at least 6 characters in length.'
                ]
            ]
        ])) {

            $validation =  session()->setFlashdata('pesan_error', \Config\Services::validation()->listErrors());
            return redirect()->to('/admin/daftar_pengguna')->withInput()->with('validation', $validation);
        }

        $this->penggunaModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'email' => $this->AES->encrypt($this->request->getVar('email'), $this->key, $this->bit),
            'password' => $this->AES->encrypt($this->request->getVar('password'), $this->key, $this->bit),
            'role_id' => $this->request->getVar('role_id'),
            'divisi_id' => $this->request->getVar('divisi_id')
        ]);

        session()->setFlashdata('pesan_pengguna', 'Pengguna Berhasil Diperbarui.');

        return redirect()->to('/admin/daftar_pengguna');
    }

    public function delete_pengguna($id)
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $this->penggunaModel->delete($id);
        session()->setFlashdata('pesan_pengguna', 'Pengguna Berhasil Dihapus.');
        return redirect()->to('/admin/daftar_pengguna');
    }

    public function profile_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $id = session()->get('id');

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'validation' => \Config\Services::validation(),
            'edit' => $this->penggunaModel->getDetailPengguna($id),
            'list_peran' => $this->penggunaModel->list_peran(),
            'divisi' => $this->penggunaModel->list_divisi(),
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('admin/profile_page', $data);
    }

    public function update_profile($id)
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|trim|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'The Nama field is required.',
                    'min_length[3]' => 'The Nama field must be at least 6 characters in length.',
                    'max_length[50]' => 'The Nama field cannot exceed 50 characters in length.'
                ]
            ],
            'email' => [
                'rules' => 'required|trim|valid_email',
                'errors' => [
                    'required' => 'The Email field is required.',
                    'valid_email' => 'The Email field must contain a valid email address.',
                    'is_unique' => 'Your Email has already been registered.',
                ]
            ],
            'password' => [
                'rules' => 'required|trim|min_length[6]',
                'errors' => [
                    'required' => 'The Password field is required.',
                    'min_length[3]' => 'The Password field must be at least 6 characters in length.'
                ]
            ]
        ])) {

            $validation =  session()->setFlashdata('pesan_error', \Config\Services::validation()->listErrors());
            return redirect()->to('/admin/profile_page')->withInput()->with('validation', $validation);
        }

        $this->penggunaModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'email' => $this->AES->encrypt($this->request->getVar('email'), $this->key, $this->bit),
            'password' => $this->AES->encrypt($this->request->getVar('password'), $this->key, $this->bit)
        ]);

        session()->setFlashdata('pesan_pengguna', 'Profil Berhasil Diperbarui.');

        return redirect()->to('/admin');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/homepage/login');
    }
}
