<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailAnggaranModel extends Model
{
    protected $table = 'detail_anggaran';
    protected $allowedFields = ['id_anggaran', 'divisi_id', 'nama', 'keterangan', 'jumlah', 'nominal', 'total'];
    protected $useTimestamps = true;

    public function add($import)
    {
        $this->db->table('detail_anggaran')->insert($import);
    }

    public function getDetail($divisi_id, $id)
    {
        return $this->db->table('detail_anggaran')
            ->select('*')
            ->where('detail_anggaran.id_anggaran', $id)
            ->where('detail_anggaran.divisi_id', $divisi_id)
            ->orderBy('id', 'DESC')
            ->get()->getResultArray();
    }

    public function deleteAll($id)
    {
        $builder = $this->table('detail_anggaran');
        $builder->where('id_anggaran', $id);
        $builder->delete();

        return $builder;
    }
}
