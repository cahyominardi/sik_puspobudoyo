<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggaranModel extends Model
{
    protected $table = 'anggaran';
    protected $allowedFields = ['divisi_id', 'nama', 'status', 'file'];
    protected $useTimestamps = true;

    public function getAnggaran($divisi_id)
    {
        return $this->db->table('anggaran')
            ->select('*')
            ->where('anggaran.divisi_id', $divisi_id)
            ->orderBy('id', 'DESC')
            ->get()->getResultArray();
    }

    public function getDetailAnggaran($id)
    {
        return $this->where(['id' => $id])->first();
    }
}
