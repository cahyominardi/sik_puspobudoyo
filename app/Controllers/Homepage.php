<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use App\Controllers\AESCTR;

class Homepage extends BaseController
{
    private $penggunaModel;
    private $AES;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
        $this->AES = new AESCTR();
        $this->key = '105216050ILMUKOMPUTER';
        $this->bit = 256;
    }

    public function index()
    {
        $data = [
            'title' => 'Sistem Informasi Keuangan Puspo Budoyo',
            'validation' => \Config\Services::validation()
        ];

        return view('homepage/loginpage', $data);
    }

    public function login()
    {
        $data = [
            'title' => 'Sistem Informasi Keuangan Puspo Budoyo',
            'validation' => \Config\Services::validation()
        ];

        return view('homepage/loginpage', $data);
    }

    public function loginaccount()
    {
        if (!$this->validate([
            'email' => [
                'rules' => 'required|trim|valid_email',
                'errors' => [
                    'required' => 'The Email field is required.',
                    'valid_email' => 'The Email field must contain a valid email address.',
                ]
            ],
            'password' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'The Password field is required.',
                    'validateuser' => 'Wrong Email or Password'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/homepage/login')->withInput()->with('validation', $validation);
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $match_user = false;

        // $pengguna = $this->penggunaModel->where(['id' => 10])->first();

        // $decrypted_email = $this->AES->decrypt($pengguna['email'], $this->key, $this->bit);

        // if ($decrypted_email == $email) {
        //     // $pengguna = $this->penggunaModel->where(['email' => $email])->first();
        //     $password_disimpen = $this->AES->decrypt($pengguna['password'], $this->key, $this->bit);

        //     if ($password == $password_disimpen) {
        //         $match_user = true;
        //     }
        // }

        $user = $this->penggunaModel->findAll();

        $jumlah_user = count($user);

        for ($i = 0; $i < $jumlah_user; $i++) {
            $decrypted_email = $this->AES->decrypt($user[$i]['email'], $this->key, $this->bit);
            $id = $user[$i]['id'];
            $pengguna = $this->penggunaModel->where(['id' => $id])->first();

            if ($decrypted_email == $email) {
                $password_disimpen = $this->AES->decrypt($pengguna['password'], $this->key, $this->bit);

                if ($password == $password_disimpen) {
                    $match_user = true;
                    break;
                }
            }
        }

        if ($pengguna) {
            if ($match_user) {
                $datauser = [
                    'id' => $pengguna['id'],
                    'nama' => $pengguna['nama'],
                    'email' => $pengguna['email'],
                    'password' => $pengguna['password'],
                    'role_id' => $pengguna['role_id'],
                    'divisi_id' => $pengguna['divisi_id']
                ];
                session()->set($datauser);
                if ($pengguna['role_id'] == 1 && $pengguna['divisi_id'] == 1) {
                    return redirect()->to('/admin');
                }
                if ($pengguna['role_id'] == 2 && $pengguna['divisi_id'] == 1) {
                    return redirect()->to('/puspobudoyo');
                }
                if ($pengguna['role_id'] == 3 && $pengguna['divisi_id'] == 2) {
                    return redirect()->to('/bendahara');
                }
                if ($pengguna['role_id'] == 3 && $pengguna['divisi_id'] == 3) {
                    return redirect()->to('/bendahara');
                }
                if ($pengguna['role_id'] == 3 && $pengguna['divisi_id'] == 4) {
                    return redirect()->to('/bendahara');
                } else {
                    return redirect()->to('/homepage');
                }
            } else {
                session()->setFlashdata('fail_login', 'Wrong Email or Password.');
            }
        } else {
            session()->setFlashdata('fail_login', 'Your email is not registered.');
        }
        return redirect()->to('/homepage/login');
    }

    public function logout()
    {
        session()->unset();
        return redirect()->to('/homepage/login');
    }
}
