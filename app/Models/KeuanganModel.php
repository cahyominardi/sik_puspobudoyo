<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganModel extends Model
{
    protected $table = 'keuangan';
    protected $allowedFields = ['divisi_id', 'jenis', 'nama', 'keterangan', 'jumlah', 'nominal', 'total'];
    protected $useTimestamps = true;

    public function getTransaksi($transaksi, $divisi_id)
    {
        return $this->db->table('keuangan')
            ->select('*')
            ->where('keuangan.divisi_id', $divisi_id)
            ->where('keuangan.jenis', $transaksi)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function rentang_transaksi($transaksi, $divisi_id, $start_date, $end_date)
    {
        return $this->db->table('keuangan')
            ->select('*')
            ->where('keuangan.divisi_id', $divisi_id)
            ->where('keuangan.jenis', $transaksi)
            ->where('created_at <=', $start_date)
            ->where('created_at >=', $end_date)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function range_transaction($transaksi, $start_date, $end_date)
    {
        return $this->db->table('keuangan')
            ->select('*')
            ->where('keuangan.jenis', $transaksi)
            ->where('created_at <=', $start_date)
            ->where('created_at >=', $end_date)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function nama_akun($transaksi)
    {
        return $this->db->table('nama_akun')
            ->select('*')
            ->where('nama_akun.jenis', $transaksi)
            ->orderBy('nama_akun', 'ASC')
            ->get()->getResultArray();
    }

    public function testing()
    {
        return $this->db->table('testing')
            ->select('*')
            ->get()->getResultArray();
    }

    public function add($import)
    {
        $this->db->table('testing')->insert($import);
    }

    public function delete_testing()
    {
        $builder = $this->db->table('testing')->emptyTable();
        return $builder;
    }
}
