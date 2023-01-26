<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table = 'pengguna';
    protected $allowedFields = ['nama', 'email', 'password', 'role_id', 'divisi_id'];

    public function list_pengguna()
    {
        return $this->db->table('pengguna')
            // ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_peran()
    {
        return $this->db->table('peran')
            // ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_divisi()
    {
        return $this->db->table('divisi')
            // ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getDetailPengguna($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function peran_pengguna()
    {
        return $this->db->table('pengguna')
            ->join('peran', 'peran.role_id = pengguna.role_id')
            ->get()->getResultArray();
    }
}
