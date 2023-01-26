<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use App\Models\KeuanganModel;
use App\Models\AnggaranModel;
use App\Models\DetailAnggaranModel;
use CodeIgniter\I18n\Time;

$myTime = new Time('+3 week');
$myTime = new Time('now');

class Puspobudoyo extends BaseController
{
    private $penggunaModel;
    private $keuanganModel;
    private $anggaranModel;
    private $detailAnggaranModel;
    private $AES;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
        $this->keuanganModel = new KeuanganModel();
        $this->anggaranModel = new AnggaranModel();
        $this->detailAnggaranModel = new DetailAnggaranModel();
        $this->Time = new Time('now', 'Etc/GMT+5', 'en_US');
        $this->AES = new AESCTR();
        $this->key = '105216050ILMUKOMPUTER';
        $this->bit = 256;
    }

    public function index()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_pagelaran = 2;
        $divisi_sekolah = 3;
        $divisi_aset = 4;

        $transaksi = 'pemasukan';
        $transaksi2 = 'pengeluaran';

        $start_date = Time::now('Etc/GMT+5', 'en_US');

        $time = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $dd = $time->getDay();
        $mm = $time->getMonth() - 1;
        $yy = $time->getYear();

        if ($mm == 0) {
            $mm = 12;
            $yy = $yy - 1;
        }

        $end_date = Time::createFromDate($yy, $mm, $dd, 'Etc/GMT+5', 'en_US');

        // ------------------ Neraca Pagelaran

        $pemasukan_pagelaran = $this->keuanganModel->getTransaksi($transaksi, $divisi_pagelaran);
        $pengeluaran_pagelaran = $this->keuanganModel->getTransaksi($transaksi2, $divisi_pagelaran);

        foreach ($pemasukan_pagelaran as $masuk) {
            $neraca_masuk2[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);
        }

        if ($pemasukan_pagelaran == null) {
            $neraca_masuk2[] = 0;
        }

        $neraca_masuk2 = array_sum($neraca_masuk2);

        foreach ($pengeluaran_pagelaran as $keluar) {
            $neraca_keluar2[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran_pagelaran == null) {
            $neraca_keluar2[] = 0;
        }

        $neraca_keluar2 = array_sum($neraca_keluar2);

        $neraca_pagelaran = $neraca_masuk2 - $neraca_keluar2;

        // ------------------ Neraca Sekolah

        $pemasukan_sekolah = $this->keuanganModel->getTransaksi($transaksi, $divisi_sekolah);
        $pengeluaran_sekolah = $this->keuanganModel->getTransaksi($transaksi2, $divisi_sekolah);

        foreach ($pemasukan_sekolah as $masuk) {
            $neraca_masuk3[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan_sekolah == null) {
            $neraca_masuk3[] = 0;
        }

        $neraca_masuk3 = array_sum($neraca_masuk3);

        foreach ($pengeluaran_sekolah as $keluar) {
            $neraca_keluar3[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran_sekolah == null) {
            $neraca_keluar3[] = 0;
        }

        $neraca_keluar3 = array_sum($neraca_keluar3);

        $neraca_sekolah = $neraca_masuk3 - $neraca_keluar3;

        // ------------------ Neraca Aset

        $pemasukan_aset = $this->keuanganModel->getTransaksi($transaksi, $divisi_aset);
        $pengeluaran_aset = $this->keuanganModel->getTransaksi($transaksi2, $divisi_aset);

        foreach ($pemasukan_aset as $masuk) {
            $neraca_masuk4[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan_aset == null) {
            $neraca_masuk4[] = 0;
        }

        $neraca_masuk4 = array_sum($neraca_masuk4);

        foreach ($pengeluaran_aset as $keluar) {
            $neraca_keluar4[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran_aset == null) {
            $neraca_keluar4[] = 0;
        }

        $neraca_keluar4 = array_sum($neraca_keluar4);

        $neraca_aset = $neraca_masuk4 - $neraca_keluar4;

        // ------------------ Pemasukan dan Pengeluaran Pagelaran

        $bulanan_masuk_pagelaran = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_pagelaran, $start_date, $end_date);
        $bulanan_keluar_pagelaran = $this->keuanganModel->rentang_transaksi($transaksi2, $divisi_pagelaran, $start_date, $end_date);

        foreach ($bulanan_masuk_pagelaran as $masuk) {
            $masuk_pagelaran[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($bulanan_masuk_pagelaran == null) {
            $masuk_pagelaran[] = 0;
        }

        $total_masuk_pagelaran = array_sum($masuk_pagelaran);

        foreach ($bulanan_keluar_pagelaran as $keluar) {
            $keluar_pagelaran[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($bulanan_keluar_pagelaran == null) {
            $keluar_pagelaran[] = 0;
        }

        $total_keluar_pagelaran = array_sum($keluar_pagelaran);

        // ------------------ Pemasukan dan Pengeluaran Sekolah

        $bulanan_masuk_sekolah = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_sekolah, $start_date, $end_date);
        $bulanan_keluar_sekolah = $this->keuanganModel->rentang_transaksi($transaksi2, $divisi_sekolah, $start_date, $end_date);

        foreach ($bulanan_masuk_sekolah as $masuk) {
            $masuk_sekolah[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($bulanan_masuk_sekolah == null) {
            $masuk_sekolah[] = 0;
        }

        $total_masuk_sekolah = array_sum($masuk_sekolah);

        foreach ($bulanan_keluar_sekolah as $keluar) {
            $keluar_sekolah[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($bulanan_keluar_sekolah == null) {
            $keluar_sekolah[] = 0;
        }

        $total_keluar_sekolah = array_sum($keluar_sekolah);

        // ------------------ Pemasukan dan Pengeluaran Aset

        $bulanan_masuk_aset = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_aset, $start_date, $end_date);
        $bulanan_keluar_aset = $this->keuanganModel->rentang_transaksi($transaksi2, $divisi_aset, $start_date, $end_date);

        foreach ($bulanan_masuk_aset as $masuk) {
            $masuk_aset[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($bulanan_masuk_aset == null) {
            $masuk_aset[] = 0;
        }

        $total_masuk_aset = array_sum($masuk_aset);

        foreach ($bulanan_keluar_aset as $keluar) {
            $keluar_aset[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($bulanan_keluar_aset == null) {
            $keluar_aset[] = 0;
        }

        $total_keluar_aset = array_sum($keluar_aset);

        /*------------------------------------------ Chart js ------------------------------------------*/

        //--------------------- Bulan ini 1
        $start_date1 = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm1 = $start_date1->getMonth();
        $yy1 = $start_date1->getYear();

        $end_date1 = Time::createFromDate($yy1, $mm1, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan1 = $this->keuanganModel->range_transaction($transaksi, $start_date1, $end_date1);
        $pengeluaran1 = $this->keuanganModel->range_transaction($transaksi2, $start_date1, $end_date1);

        foreach ($pemasukan1 as $masuk) {
            $masuk1[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan1 == null) {
            $masuk1[] = 0;
        }

        $pemasukan_bln1 = array_sum($masuk1);

        foreach ($pengeluaran1 as $keluar) {
            $keluar1[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran1 == null) {
            $keluar1[] = 0;
        }

        $pengeluaran_bln1 = array_sum($keluar1);

        $nama_bln1 = $mm1;

        switch ($nama_bln1) {
            case '1':
                $nama_bln1 = 'Januari ' . $yy1;
                break;
            case '2':
                $nama_bln1 = 'Februari ' . $yy1;
                break;
            case '3':
                $nama_bln1 = 'Maret ' . $yy1;
                break;
            case '4':
                $nama_bln1 = 'April ' . $yy1;
                break;
            case '5':
                $nama_bln1 = 'Mei ' . $yy1;
                break;
            case '6':
                $nama_bln1 = 'Juni ' . $yy1;
                break;
            case '7':
                $nama_bln1 = 'Juli ' . $yy1;
                break;
            case '8':
                $nama_bln1 = 'Agustus ' . $yy1;
                break;
            case '9':
                $nama_bln1 = 'September ' . $yy1;
                break;
            case '10':
                $nama_bln1 = 'Oktober ' . $yy1;
                break;
            case '11':
                $nama_bln1 = 'November ' . $yy1;
                break;
            case '12':
                $nama_bln1 = 'December ' . $yy1;
                break;
        }

        //--------------------- Bulan 2
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm2 = $initial_date->getMonth() - 1;
        $yy2 = $initial_date->getYear();

        if ($mm2 <= 0) {
            $mm2 = 12 + $mm2;
            $yy2 = $yy2 - 1;
        }

        $start_date2 = Time::createFromDate($yy2, $mm2, 31, 'Etc/GMT+5', 'en_US');
        $end_date2 = Time::createFromDate($yy2, $mm2, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan2 = $this->keuanganModel->range_transaction($transaksi, $start_date2, $end_date2);
        $pengeluaran2 = $this->keuanganModel->range_transaction($transaksi2, $start_date2, $end_date2);

        foreach ($pemasukan2 as $masuk) {
            $masuk2[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan2 == null) {
            $masuk2[] = 0;
        }

        $pemasukan_bln2 = array_sum($masuk2);

        foreach ($pengeluaran2 as $keluar) {
            $keluar2[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran2 == null) {
            $keluar2[] = 0;
        }

        $pengeluaran_bln2 = array_sum($keluar2);

        $nama_bln2 = $mm2;

        switch ($nama_bln2) {
            case '1':
                $nama_bln2 = 'Januari ' . $yy2;
                break;
            case '2':
                $nama_bln2 = 'Februari ' . $yy2;
                break;
            case '3':
                $nama_bln2 = 'Maret ' . $yy2;
                break;
            case '4':
                $nama_bln2 = 'April ' . $yy2;
                break;
            case '5':
                $nama_bln2 = 'Mei ' . $yy2;
                break;
            case '6':
                $nama_bln2 = 'Juni ' . $yy2;
                break;
            case '7':
                $nama_bln2 = 'Juli ' . $yy2;
                break;
            case '8':
                $nama_bln2 = 'Agustus ' . $yy2;
                break;
            case '9':
                $nama_bln2 = 'September ' . $yy2;
                break;
            case '10':
                $nama_bln2 = 'Oktober ' . $yy2;
                break;
            case '11':
                $nama_bln2 = 'November ' . $yy2;
                break;
            case '12':
                $nama_bln2 = 'December ' . $yy2;
                break;
        }

        //--------------------- Bulan 3
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm3 = $initial_date->getMonth() - 2;
        $yy3 = $initial_date->getYear();

        if ($mm3 <= 0) {
            $mm3 = 12 + $mm3;
            $yy3 = $yy3 - 1;
        }

        $start_date3 = Time::createFromDate($yy3, $mm3, 31, 'Etc/GMT+5', 'en_US');
        $end_date3 = Time::createFromDate($yy3, $mm3, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan3 = $this->keuanganModel->range_transaction($transaksi, $start_date3, $end_date3);
        $pengeluaran3 = $this->keuanganModel->range_transaction($transaksi2, $start_date3, $end_date3);

        foreach ($pemasukan3 as $masuk) {
            $masuk3[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan3 == null) {
            $masuk3[] = 0;
        }

        $pemasukan_bln3 = array_sum($masuk3);

        foreach ($pengeluaran3 as $keluar) {
            $keluar3[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran3 == null) {
            $keluar3[] = 0;
        }

        $pengeluaran_bln3 = array_sum($keluar3);

        $nama_bln3 = $mm3;

        switch ($nama_bln3) {
            case '1':
                $nama_bln3 = 'Januari ' . $yy3;
                break;
            case '2':
                $nama_bln3 = 'Februari ' . $yy3;
                break;
            case '3':
                $nama_bln3 = 'Maret ' . $yy3;
                break;
            case '4':
                $nama_bln3 = 'April ' . $yy3;
                break;
            case '5':
                $nama_bln3 = 'Mei ' . $yy3;
                break;
            case '6':
                $nama_bln3 = 'Juni ' . $yy3;
                break;
            case '7':
                $nama_bln3 = 'Juli ' . $yy3;
                break;
            case '8':
                $nama_bln3 = 'Agustus ' . $yy3;
                break;
            case '9':
                $nama_bln3 = 'September ' . $yy3;
                break;
            case '10':
                $nama_bln3 = 'Oktober ' . $yy3;
                break;
            case '11':
                $nama_bln3 = 'November ' . $yy3;
                break;
            case '12':
                $nama_bln3 = 'December ' . $yy3;
                break;
        }

        //--------------------- Bulan 4
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm4 = $initial_date->getMonth() - 3;
        $yy4 = $initial_date->getYear();

        if ($mm4 <= 0) {
            $mm4 = 12 + $mm4;
            $yy4 = $yy4 - 1;
        }

        $start_date4 = Time::createFromDate($yy4, $mm4, 31, 'Etc/GMT+5', 'en_US');
        $end_date4 = Time::createFromDate($yy4, $mm4, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan4 = $this->keuanganModel->range_transaction($transaksi, $start_date4, $end_date4);
        $pengeluaran4 = $this->keuanganModel->range_transaction($transaksi2, $start_date4, $end_date4);

        foreach ($pemasukan4 as $masuk) {
            $masuk4[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan4 == null) {
            $masuk4[] = 0;
        }

        $pemasukan_bln4 = array_sum($masuk4);

        foreach ($pengeluaran4 as $keluar) {
            $keluar4[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran4 == null) {
            $keluar4[] = 0;
        }

        $pengeluaran_bln4 = array_sum($keluar4);

        $nama_bln4 = $mm4;

        switch ($nama_bln4) {
            case '1':
                $nama_bln4 = 'Januari ' . $yy4;
                break;
            case '2':
                $nama_bln4 = 'Februari ' . $yy4;
                break;
            case '3':
                $nama_bln4 = 'Maret ' . $yy4;
                break;
            case '4':
                $nama_bln4 = 'April ' . $yy4;
                break;
            case '5':
                $nama_bln4 = 'Mei ' . $yy4;
                break;
            case '6':
                $nama_bln4 = 'Juni ' . $yy4;
                break;
            case '7':
                $nama_bln4 = 'Juli ' . $yy4;
                break;
            case '8':
                $nama_bln4 = 'Agustus ' . $yy4;
                break;
            case '9':
                $nama_bln4 = 'September ' . $yy4;
                break;
            case '10':
                $nama_bln4 = 'Oktober ' . $yy4;
                break;
            case '11':
                $nama_bln4 = 'November ' . $yy4;
                break;
            case '12':
                $nama_bln4 = 'December ' . $yy4;
                break;
        }

        //--------------------- Bulan 5
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm5 = $initial_date->getMonth() - 4;
        $yy5 = $initial_date->getYear();

        if ($mm5 <= 0) {
            $mm5 = 12 + $mm5;
            $yy5 = $yy5 - 1;
        }

        $start_date5 = Time::createFromDate($yy5, $mm5, 31, 'Etc/GMT+5', 'en_US');
        $end_date5 = Time::createFromDate($yy5, $mm5, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan5 = $this->keuanganModel->range_transaction($transaksi, $start_date5, $end_date5);
        $pengeluaran5 = $this->keuanganModel->range_transaction($transaksi2, $start_date5, $end_date5);

        foreach ($pemasukan5 as $masuk) {
            $masuk5[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan5 == null) {
            $masuk5[] = 0;
        }

        $pemasukan_bln5 = array_sum($masuk5);

        foreach ($pengeluaran5 as $keluar) {
            $keluar5[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran5 == null) {
            $keluar5[] = 0;
        }

        $pengeluaran_bln5 = array_sum($keluar5);

        $nama_bln5 = $mm5;

        switch ($nama_bln5) {
            case '1':
                $nama_bln5 = 'Januari ' . $yy5;
                break;
            case '2':
                $nama_bln5 = 'Februari ' . $yy5;
                break;
            case '3':
                $nama_bln5 = 'Maret ' . $yy5;
                break;
            case '4':
                $nama_bln5 = 'April ' . $yy5;
                break;
            case '5':
                $nama_bln5 = 'Mei ' . $yy5;
                break;
            case '6':
                $nama_bln5 = 'Juni ' . $yy5;
                break;
            case '7':
                $nama_bln5 = 'Juli ' . $yy5;
                break;
            case '8':
                $nama_bln5 = 'Agustus ' . $yy5;
                break;
            case '9':
                $nama_bln5 = 'September ' . $yy5;
                break;
            case '10':
                $nama_bln5 = 'Oktober ' . $yy5;
                break;
            case '11':
                $nama_bln5 = 'November ' . $yy5;
                break;
            case '12':
                $nama_bln5 = 'December ' . $yy5;
                break;
        }

        //--------------------- Bulan 6
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm6 = $initial_date->getMonth() - 5;
        $yy6 = $initial_date->getYear();

        if ($mm6 <= 0) {
            $mm6 = 12 + $mm6;
            $yy6 = $yy6 - 1;
        }

        $start_date6 = Time::createFromDate($yy6, $mm6, 31, 'Etc/GMT+5', 'en_US');
        $end_date6 = Time::createFromDate($yy6, $mm6, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan6 = $this->keuanganModel->range_transaction($transaksi, $start_date6, $end_date6);
        $pengeluaran6 = $this->keuanganModel->range_transaction($transaksi2, $start_date6, $end_date6);

        foreach ($pemasukan6 as $masuk) {
            $masuk6[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan6 == null) {
            $masuk6[] = 0;
        }

        $pemasukan_bln6 = array_sum($masuk6);

        foreach ($pengeluaran6 as $keluar) {
            $keluar6[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran6 == null) {
            $keluar6[] = 0;
        }

        $pengeluaran_bln6 = array_sum($keluar6);

        $nama_bln6 = $mm6;

        switch ($nama_bln6) {
            case '1':
                $nama_bln6 = 'Januari ' . $yy6;
                break;
            case '2':
                $nama_bln6 = 'Februari ' . $yy6;
                break;
            case '3':
                $nama_bln6 = 'Maret ' . $yy6;
                break;
            case '4':
                $nama_bln6 = 'April ' . $yy6;
                break;
            case '5':
                $nama_bln6 = 'Mei ' . $yy6;
                break;
            case '6':
                $nama_bln6 = 'Juni ' . $yy6;
                break;
            case '7':
                $nama_bln6 = 'Juli ' . $yy6;
                break;
            case '8':
                $nama_bln6 = 'Agustus ' . $yy6;
                break;
            case '9':
                $nama_bln6 = 'September ' . $yy6;
                break;
            case '10':
                $nama_bln6 = 'Oktober ' . $yy6;
                break;
            case '11':
                $nama_bln6 = 'November ' . $yy6;
                break;
            case '12':
                $nama_bln6 = 'December ' . $yy6;
                break;
        }

        //--------------------- Bulan 7
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm7 = $initial_date->getMonth() - 6;
        $yy7 = $initial_date->getYear();

        if ($mm7 <= 0) {
            $mm7 = 12 + $mm7;
            $yy7 = $yy7 - 1;
        }

        $start_date7 = Time::createFromDate($yy7, $mm7, 31, 'Etc/GMT+5', 'en_US');
        $end_date7 = Time::createFromDate($yy7, $mm7, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan7 = $this->keuanganModel->range_transaction($transaksi, $start_date7, $end_date7);
        $pengeluaran7 = $this->keuanganModel->range_transaction($transaksi2, $start_date7, $end_date7);

        foreach ($pemasukan7 as $masuk) {
            $masuk7[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan7 == null) {
            $masuk7[] = 0;
        }

        $pemasukan_bln7 = array_sum($masuk7);

        foreach ($pengeluaran7 as $keluar) {
            $keluar7[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran7 == null) {
            $keluar7[] = 0;
        }

        $pengeluaran_bln7 = array_sum($keluar7);

        $nama_bln7 = $mm7;

        switch ($nama_bln7) {
            case '1':
                $nama_bln7 = 'Januari ' . $yy7;
                break;
            case '2':
                $nama_bln7 = 'Februari ' . $yy7;
                break;
            case '3':
                $nama_bln7 = 'Maret ' . $yy7;
                break;
            case '4':
                $nama_bln7 = 'April ' . $yy7;
                break;
            case '5':
                $nama_bln7 = 'Mei ' . $yy7;
                break;
            case '6':
                $nama_bln7 = 'Juni ' . $yy7;
                break;
            case '7':
                $nama_bln7 = 'Juli ' . $yy7;
                break;
            case '8':
                $nama_bln7 = 'Agustus ' . $yy7;
                break;
            case '9':
                $nama_bln7 = 'September ' . $yy7;
                break;
            case '10':
                $nama_bln7 = 'Oktober ' . $yy7;
                break;
            case '11':
                $nama_bln7 = 'November ' . $yy7;
                break;
            case '12':
                $nama_bln7 = 'December ' . $yy7;
                break;
        }

        //--------------------- Bulan 8
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm8 = $initial_date->getMonth() - 7;
        $yy8 = $initial_date->getYear();

        if ($mm8 <= 0) {
            $mm8 = 12 + $mm8;
            $yy8 = $yy8 - 1;
        }

        $start_date8 = Time::createFromDate($yy8, $mm8, 31, 'Etc/GMT+5', 'en_US');
        $end_date8 = Time::createFromDate($yy8, $mm8, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan8 = $this->keuanganModel->range_transaction($transaksi, $start_date8, $end_date8);
        $pengeluaran8 = $this->keuanganModel->range_transaction($transaksi2, $start_date8, $end_date8);

        foreach ($pemasukan8 as $masuk) {
            $masuk8[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan8 == null) {
            $masuk8[] = 0;
        }

        $pemasukan_bln8 = array_sum($masuk8);

        foreach ($pengeluaran8 as $keluar) {
            $keluar8[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran8 == null) {
            $keluar8[] = 0;
        }

        $pengeluaran_bln8 = array_sum($keluar8);

        $nama_bln8 = $mm8;

        switch ($nama_bln8) {
            case '1':
                $nama_bln8 = 'Januari ' . $yy8;
                break;
            case '2':
                $nama_bln8 = 'Februari ' . $yy8;
                break;
            case '3':
                $nama_bln8 = 'Maret ' . $yy8;
                break;
            case '4':
                $nama_bln8 = 'April ' . $yy8;
                break;
            case '5':
                $nama_bln8 = 'Mei ' . $yy8;
                break;
            case '6':
                $nama_bln8 = 'Juni ' . $yy8;
                break;
            case '7':
                $nama_bln8 = 'Juli ' . $yy8;
                break;
            case '8':
                $nama_bln8 = 'Agustus ' . $yy8;
                break;
            case '9':
                $nama_bln8 = 'September ' . $yy8;
                break;
            case '10':
                $nama_bln8 = 'Oktober ' . $yy8;
                break;
            case '11':
                $nama_bln8 = 'November ' . $yy8;
                break;
            case '12':
                $nama_bln8 = 'December ' . $yy8;
                break;
        }

        //--------------------- Bulan 9
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm9 = $initial_date->getMonth() - 8;
        $yy9 = $initial_date->getYear();

        if ($mm9 <= 0) {
            $mm9 = 12 + $mm9;
            $yy9 = $yy9 - 1;
        }

        $start_date9 = Time::createFromDate($yy9, $mm9, 31, 'Etc/GMT+5', 'en_US');
        $end_date9 = Time::createFromDate($yy9, $mm9, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan9 = $this->keuanganModel->range_transaction($transaksi, $start_date9, $end_date9);
        $pengeluaran9 = $this->keuanganModel->range_transaction($transaksi2, $start_date9, $end_date9);

        foreach ($pemasukan9 as $masuk) {
            $masuk9[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan9 == null) {
            $masuk9[] = 0;
        }

        $pemasukan_bln9 = array_sum($masuk9);

        foreach ($pengeluaran9 as $keluar) {
            $keluar9[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran9 == null) {
            $keluar9[] = 0;
        }

        $pengeluaran_bln9 = array_sum($keluar9);

        $nama_bln9 = $mm9;

        switch ($nama_bln9) {
            case '1':
                $nama_bln9 = 'Januari ' . $yy9;
                break;
            case '2':
                $nama_bln9 = 'Februari ' . $yy9;
                break;
            case '3':
                $nama_bln9 = 'Maret ' . $yy9;
                break;
            case '4':
                $nama_bln9 = 'April ' . $yy9;
                break;
            case '5':
                $nama_bln9 = 'Mei ' . $yy9;
                break;
            case '6':
                $nama_bln9 = 'Juni ' . $yy9;
                break;
            case '7':
                $nama_bln9 = 'Juli ' . $yy9;
                break;
            case '8':
                $nama_bln9 = 'Agustus ' . $yy9;
                break;
            case '9':
                $nama_bln9 = 'September ' . $yy9;
                break;
            case '10':
                $nama_bln9 = 'Oktober ' . $yy9;
                break;
            case '11':
                $nama_bln9 = 'November ' . $yy9;
                break;
            case '12':
                $nama_bln9 = 'December ' . $yy9;
                break;
        }

        //--------------------- Bulan 10
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm10 = $initial_date->getMonth() - 9;
        $yy10 = $initial_date->getYear();

        if ($mm10 <= 0) {
            $mm10 = 12 + $mm10;
            $yy10 = $yy10 - 1;
        }

        $start_date10 = Time::createFromDate($yy10, $mm10, 31, 'Etc/GMT+5', 'en_US');
        $end_date10 = Time::createFromDate($yy10, $mm10, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan10 = $this->keuanganModel->range_transaction($transaksi, $start_date10, $end_date10);
        $pengeluaran10 = $this->keuanganModel->range_transaction($transaksi2, $start_date10, $end_date10);

        foreach ($pemasukan10 as $masuk) {
            $masuk10[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan10 == null) {
            $masuk10[] = 0;
        }

        $pemasukan_bln10 = array_sum($masuk10);

        foreach ($pengeluaran10 as $keluar) {
            $keluar10[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran10 == null) {
            $keluar10[] = 0;
        }

        $pengeluaran_bln10 = array_sum($keluar10);

        $nama_bln10 = $mm10;

        switch ($nama_bln10) {
            case '1':
                $nama_bln10 = 'Januari ' . $yy10;
                break;
            case '2':
                $nama_bln10 = 'Februari ' . $yy10;
                break;
            case '3':
                $nama_bln10 = 'Maret ' . $yy10;
                break;
            case '4':
                $nama_bln10 = 'April ' . $yy10;
                break;
            case '5':
                $nama_bln10 = 'Mei ' . $yy10;
                break;
            case '6':
                $nama_bln10 = 'Juni ' . $yy10;
                break;
            case '7':
                $nama_bln10 = 'Juli ' . $yy10;
                break;
            case '8':
                $nama_bln10 = 'Agustus ' . $yy10;
                break;
            case '9':
                $nama_bln10 = 'September ' . $yy10;
                break;
            case '10':
                $nama_bln10 = 'Oktober ' . $yy10;
                break;
            case '11':
                $nama_bln10 = 'November ' . $yy10;
                break;
            case '12':
                $nama_bln10 = 'December ' . $yy10;
                break;
        }

        //--------------------- Bulan 11
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm11 = $initial_date->getMonth() - 10;
        $yy11 = $initial_date->getYear();

        if ($mm11 <= 0) {
            $mm11 = 12 + $mm11;
            $yy11 = $yy11 - 1;
        }

        $start_date11 = Time::createFromDate($yy11, $mm11, 31, 'Etc/GMT+5', 'en_US');
        $end_date11 = Time::createFromDate($yy11, $mm11, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan11 = $this->keuanganModel->range_transaction($transaksi, $start_date11, $end_date11);
        $pengeluaran11 = $this->keuanganModel->range_transaction($transaksi2, $start_date11, $end_date11);

        foreach ($pemasukan11 as $masuk) {
            $masuk11[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan11 == null) {
            $masuk11[] = 0;
        }

        $pemasukan_bln11 = array_sum($masuk11);

        foreach ($pengeluaran11 as $keluar) {
            $keluar11[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran11 == null) {
            $keluar11[] = 0;
        }

        $pengeluaran_bln11 = array_sum($keluar11);

        $nama_bln11 = $mm11;

        switch ($nama_bln11) {
            case '1':
                $nama_bln11 = 'Januari ' . $yy11;
                break;
            case '2':
                $nama_bln11 = 'Februari ' . $yy11;
                break;
            case '3':
                $nama_bln11 = 'Maret ' . $yy11;
                break;
            case '4':
                $nama_bln11 = 'April ' . $yy11;
                break;
            case '5':
                $nama_bln11 = 'Mei ' . $yy11;
                break;
            case '6':
                $nama_bln11 = 'Juni ' . $yy11;
                break;
            case '7':
                $nama_bln11 = 'Juli ' . $yy11;
                break;
            case '8':
                $nama_bln11 = 'Agustus ' . $yy11;
                break;
            case '9':
                $nama_bln11 = 'September ' . $yy11;
                break;
            case '10':
                $nama_bln11 = 'Oktober ' . $yy11;
                break;
            case '11':
                $nama_bln11 = 'November ' . $yy11;
                break;
            case '12':
                $nama_bln11 = 'December ' . $yy11;
                break;
        }

        //--------------------- Bulan 12
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $mm12 = $initial_date->getMonth() - 11;
        $yy12 = $initial_date->getYear();

        if ($mm12 <= 0) {
            $mm12 = 12 + $mm12;
            $yy12 = $yy12 - 1;
        }

        $start_date12 = Time::createFromDate($yy12, $mm12, 31, 'Etc/GMT+5', 'en_US');
        $end_date12 = Time::createFromDate($yy12, $mm12, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan12 = $this->keuanganModel->range_transaction($transaksi, $start_date12, $end_date12);
        $pengeluaran12 = $this->keuanganModel->range_transaction($transaksi2, $start_date12, $end_date12);

        foreach ($pemasukan12 as $masuk) {
            $masuk12[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan12 == null) {
            $masuk12[] = 0;
        }

        $pemasukan_bln12 = array_sum($masuk12);

        foreach ($pengeluaran12 as $keluar) {
            $keluar12[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran12 == null) {
            $keluar12[] = 0;
        }

        $pengeluaran_bln12 = array_sum($keluar12);

        $nama_bln12 = $mm12;

        switch ($nama_bln12) {
            case '1':
                $nama_bln12 = 'Januari ' . $yy12;
                break;
            case '2':
                $nama_bln12 = 'Februari ' . $yy12;
                break;
            case '3':
                $nama_bln12 = 'Maret ' . $yy12;
                break;
            case '4':
                $nama_bln12 = 'April ' . $yy12;
                break;
            case '5':
                $nama_bln12 = 'Mei ' . $yy12;
                break;
            case '6':
                $nama_bln12 = 'Juni ' . $yy12;
                break;
            case '7':
                $nama_bln12 = 'Juli ' . $yy12;
                break;
            case '8':
                $nama_bln12 = 'Agustus ' . $yy12;
                break;
            case '9':
                $nama_bln12 = 'September ' . $yy12;
                break;
            case '10':
                $nama_bln12 = 'Oktober ' . $yy12;
                break;
            case '11':
                $nama_bln12 = 'November ' . $yy12;
                break;
            case '12':
                $nama_bln12 = 'December ' . $yy12;
                break;
        }

        //--------------------- Tahun 1
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $year1 = $initial_date->getYear();

        $start_year1 = Time::now('Etc/GMT+5', 'en_US');
        $end_year1 = Time::createFromDate($year1, 1, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan13 = $this->keuanganModel->range_transaction($transaksi, $start_year1, $end_year1);
        $pengeluaran13 = $this->keuanganModel->range_transaction($transaksi2, $start_year1, $end_year1);

        foreach ($pemasukan13 as $masuk) {
            $masuk13[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan13 == null) {
            $masuk13[] = 0;
        }

        $pemasukan_thn1 = array_sum($masuk13);

        foreach ($pengeluaran13 as $keluar) {
            $keluar13[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran13 == null) {
            $keluar13[] = 0;
        }

        $pengeluaran_thn1 = array_sum($keluar13);

        //--------------------- Tahun 2
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $year2 = $initial_date->getYear() - 1;

        $start_year2 = Time::createFromDate($year2, 12, 31, 'Etc/GMT+5', 'en_US');
        $end_year2 = Time::createFromDate($year2, 1, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan14 = $this->keuanganModel->range_transaction($transaksi, $start_year2, $end_year2);
        $pengeluaran14 = $this->keuanganModel->range_transaction($transaksi2, $start_year2, $end_year2);

        foreach ($pemasukan14 as $masuk) {
            $masuk14[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan14 == null) {
            $masuk14[] = 0;
        }

        $pemasukan_thn2 = array_sum($masuk14);

        foreach ($pengeluaran14 as $keluar) {
            $keluar14[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran14 == null) {
            $keluar14[] = 0;
        }

        $pengeluaran_thn2 = array_sum($keluar14);

        //--------------------- Tahun 3
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $year3 = $initial_date->getYear() - 2;

        $start_year3 = Time::createFromDate($year3, 12, 31, 'Etc/GMT+5', 'en_US');
        $end_year3 = Time::createFromDate($year3, 1, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan15 = $this->keuanganModel->range_transaction($transaksi, $start_year3, $end_year3);
        $pengeluaran15 = $this->keuanganModel->range_transaction($transaksi2, $start_year3, $end_year3);

        foreach ($pemasukan15 as $masuk) {
            $masuk15[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan15 == null) {
            $masuk15[] = 0;
        }

        $pemasukan_thn3 = array_sum($masuk15);

        foreach ($pengeluaran15 as $keluar) {
            $keluar15[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran15 == null) {
            $keluar15[] = 0;
        }

        $pengeluaran_thn3 = array_sum($keluar15);

        //--------------------- Tahun 4
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $year4 = $initial_date->getYear() - 3;

        $start_year4 = Time::createFromDate($year4, 12, 31, 'Etc/GMT+5', 'en_US');
        $end_year4 = Time::createFromDate($year4, 1, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan16 = $this->keuanganModel->range_transaction($transaksi, $start_year4, $end_year4);
        $pengeluaran16 = $this->keuanganModel->range_transaction($transaksi2, $start_year4, $end_year4);

        foreach ($pemasukan16 as $masuk) {
            $masuk16[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan16 == null) {
            $masuk16[] = 0;
        }

        $pemasukan_thn4 = array_sum($masuk16);

        foreach ($pengeluaran16 as $keluar) {
            $keluar16[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran16 == null) {
            $keluar16[] = 0;
        }

        $pengeluaran_thn4 = array_sum($keluar16);

        //--------------------- Tahun 5
        $initial_date = Time::parse(Time::now('Etc/GMT+5', 'en_US'));
        $year5 = $initial_date->getYear() - 4;

        $start_year5 = Time::createFromDate($year5, 12, 31, 'Etc/GMT+5', 'en_US');
        $end_year5 = Time::createFromDate($year5, 1, 1, 'Etc/GMT+5', 'en_US');

        $pemasukan17 = $this->keuanganModel->range_transaction($transaksi, $start_year5, $end_year5);
        $pengeluaran17 = $this->keuanganModel->range_transaction($transaksi2, $start_year5, $end_year5);

        foreach ($pemasukan17 as $masuk) {
            $masuk17[] = $this->AES->decrypt($masuk['total'], $this->key, $this->bit);;
        }

        if ($pemasukan17 == null) {
            $masuk17[] = 0;
        }

        $pemasukan_thn5 = array_sum($masuk17);

        foreach ($pengeluaran17 as $keluar) {
            $keluar17[] = $this->AES->decrypt($keluar['total'], $this->key, $this->bit);
        }

        if ($pengeluaran17 == null) {
            $keluar17[] = 0;
        }

        $pengeluaran_thn5 = array_sum($keluar17);

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'nama' => session()->get('nama'),
            'neraca_pagelaran' => $neraca_pagelaran,
            'neraca_sekolah' => $neraca_sekolah,
            'neraca_aset' => $neraca_aset,
            'neraca' => $neraca_pagelaran + $neraca_sekolah + $neraca_aset,
            'total_masuk_pagelaran' => $total_masuk_pagelaran,
            'total_keluar_pagelaran' => $total_keluar_pagelaran,
            'total_masuk_sekolah' => $total_masuk_sekolah,
            'total_keluar_sekolah' => $total_keluar_sekolah,
            'total_masuk_aset' => $total_masuk_aset,
            'total_keluar_aset' => $total_keluar_aset,
            'total_pemasukan' => $neraca_masuk2 + $neraca_masuk3 + $neraca_masuk4,
            'total_pengeluaran' => $neraca_keluar2 + $neraca_keluar3 + $neraca_keluar4,
            'nama_bln1' => $nama_bln1,
            'nama_bln2' => $nama_bln2,
            'nama_bln3' => $nama_bln3,
            'nama_bln4' => $nama_bln4,
            'nama_bln5' => $nama_bln5,
            'nama_bln6' => $nama_bln6,
            'nama_bln7' => $nama_bln7,
            'nama_bln8' => $nama_bln8,
            'nama_bln9' => $nama_bln9,
            'nama_bln10' => $nama_bln10,
            'nama_bln11' => $nama_bln11,
            'nama_bln12' => $nama_bln12,
            'pemasukan_bln1' => $pemasukan_bln1,
            'pemasukan_bln2' => $pemasukan_bln2,
            'pemasukan_bln3' => $pemasukan_bln3,
            'pemasukan_bln4' => $pemasukan_bln4,
            'pemasukan_bln5' => $pemasukan_bln5,
            'pemasukan_bln6' => $pemasukan_bln6,
            'pemasukan_bln7' => $pemasukan_bln7,
            'pemasukan_bln8' => $pemasukan_bln8,
            'pemasukan_bln9' => $pemasukan_bln9,
            'pemasukan_bln10' => $pemasukan_bln10,
            'pemasukan_bln11' => $pemasukan_bln11,
            'pemasukan_bln12' => $pemasukan_bln12,
            'pengeluaran_bln1' => $pengeluaran_bln1,
            'pengeluaran_bln2' => $pengeluaran_bln2,
            'pengeluaran_bln3' => $pengeluaran_bln3,
            'pengeluaran_bln4' => $pengeluaran_bln4,
            'pengeluaran_bln5' => $pengeluaran_bln5,
            'pengeluaran_bln6' => $pengeluaran_bln6,
            'pengeluaran_bln7' => $pengeluaran_bln7,
            'pengeluaran_bln8' => $pengeluaran_bln8,
            'pengeluaran_bln9' => $pengeluaran_bln9,
            'pengeluaran_bln10' => $pengeluaran_bln10,
            'pengeluaran_bln11' => $pengeluaran_bln11,
            'pengeluaran_bln12' => $pengeluaran_bln12,
            'year1' => $year1,
            'year2' => $year2,
            'year3' => $year3,
            'year4' => $year4,
            'year5' => $year5,
            'pemasukan_thn1' => $pemasukan_thn1,
            'pemasukan_thn2' => $pemasukan_thn2,
            'pemasukan_thn3' => $pemasukan_thn3,
            'pemasukan_thn4' => $pemasukan_thn4,
            'pemasukan_thn5' => $pemasukan_thn5,
            'pengeluaran_thn1' => $pengeluaran_thn1,
            'pengeluaran_thn2' => $pengeluaran_thn2,
            'pengeluaran_thn3' => $pengeluaran_thn3,
            'pengeluaran_thn4' => $pengeluaran_thn4,
            'pengeluaran_thn5' => $pengeluaran_thn5
        ];

        return view('puspobudoyo/dashboard', $data);
    }

    public function pemasukan_pagelaran_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $transaksi = 'pemasukan';
        $divisi_id =  2;

        // Search 

        $keyword = $this->request->getVar('keyword');

        // Search by date

        $start_date = $this->request->getVar('startdate');
        $end_date = $this->request->getVar('enddate');

        if ($keyword) {
            $pemasukan = $this->keuanganModel->search($transaksi, $divisi_id, $keyword);
        } elseif ($start_date && $end_date) {
            $pemasukan = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_id, $end_date, $start_date);
        } else {
            $pemasukan = $this->keuanganModel->getTransaksi($transaksi, $divisi_id);
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'keuangan' => $pemasukan,
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('puspobudoyo/pemasukan_pagelaran_page', $data);
    }

    public function pengeluaran_pagelaran_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_id =  2;
        $transaksi = 'pengeluaran';

        // Search 

        $keyword = $this->request->getVar('keyword');

        // Search by date

        $start_date = $this->request->getVar('startdate');
        $end_date = $this->request->getVar('enddate');

        if ($keyword) {
            $pengeluaran = $this->keuanganModel->search($transaksi, $divisi_id, $keyword);
        } elseif ($start_date && $end_date) {
            $pengeluaran = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_id, $end_date, $start_date);
        } else {
            $pengeluaran = $this->keuanganModel->getTransaksi($transaksi, $divisi_id);
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'keuangan' => $pengeluaran,
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('puspobudoyo/pengeluaran_pagelaran_page', $data);
    }

    public function pemasukan_sekolah_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $transaksi = 'pemasukan';
        $divisi_id =  3;

        // Search 

        $keyword = $this->request->getVar('keyword');

        // Search by date

        $start_date = $this->request->getVar('startdate');
        $end_date = $this->request->getVar('enddate');

        if ($keyword) {
            $pemasukan = $this->keuanganModel->search($transaksi, $divisi_id, $keyword);
        } elseif ($start_date && $end_date) {
            $pemasukan = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_id, $end_date, $start_date);
        } else {
            $pemasukan = $this->keuanganModel->getTransaksi($transaksi, $divisi_id);
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'keuangan' => $pemasukan,
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('puspobudoyo/pemasukan_sekolah_page', $data);
    }

    public function pengeluaran_sekolah_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_id =  3;
        $transaksi = 'pengeluaran';

        // Search 

        $keyword = $this->request->getVar('keyword');

        // Search by date

        $start_date = $this->request->getVar('startdate');
        $end_date = $this->request->getVar('enddate');

        if ($keyword) {
            $pengeluaran = $this->keuanganModel->search($transaksi, $divisi_id, $keyword);
        } elseif ($start_date && $end_date) {
            $pengeluaran = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_id, $end_date, $start_date);
        } else {
            $pengeluaran = $this->keuanganModel->getTransaksi($transaksi, $divisi_id);
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'keuangan' => $pengeluaran,
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];
        return view('puspobudoyo/pengeluaran_sekolah_page', $data);
    }

    public function pemasukan_aset_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $transaksi = 'pemasukan';
        $divisi_id =  4;

        // Search 

        $keyword = $this->request->getVar('keyword');

        // Search by date

        $start_date = $this->request->getVar('startdate');
        $end_date = $this->request->getVar('enddate');

        if ($keyword) {
            $pemasukan = $this->keuanganModel->search($transaksi, $divisi_id, $keyword);
        } elseif ($start_date && $end_date) {
            $pemasukan = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_id, $end_date, $start_date);
        } else {
            $pemasukan = $this->keuanganModel->getTransaksi($transaksi, $divisi_id);
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'keuangan' => $pemasukan,
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('puspobudoyo/pemasukan_aset_page', $data);
    }

    public function pengeluaran_aset_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_id =  4;
        $transaksi = 'pengeluaran';

        $keyword = $this->request->getVar('keyword');

        // Search by date

        $start_date = $this->request->getVar('startdate');
        $end_date = $this->request->getVar('enddate');

        if ($keyword) {
            $pengeluaran = $this->keuanganModel->search($transaksi, $divisi_id, $keyword);
        } elseif ($start_date && $end_date) {
            $pengeluaran = $this->keuanganModel->rentang_transaksi($transaksi, $divisi_id, $end_date, $start_date);
        } else {
            $pengeluaran = $this->keuanganModel->getTransaksi($transaksi, $divisi_id);
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'keuangan' => $pengeluaran,
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('puspobudoyo/pengeluaran_aset_page', $data);
    }

    public function anggaran_pagelaran_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_id =  2;

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'anggaran' => $this->anggaranModel->getAnggaran($divisi_id),
            'div_id' => $divisi_id
        ];

        return view('puspobudoyo/anggaran_pagelaran_page', $data);
    }

    public function anggaran_sekolah_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_id =  3;

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'anggaran' => $this->anggaranModel->getAnggaran($divisi_id),
            'div_id' => $divisi_id
        ];

        return view('puspobudoyo/anggaran_sekolah_page', $data);
    }

    public function anggaran_aset_page()
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_id =  4;

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'anggaran' => $this->anggaranModel->getAnggaran($divisi_id),
            'div_id' => $divisi_id
        ];

        return view('puspobudoyo/anggaran_aset_page', $data);
    }

    public function detail_anggaran_page($div_id, $id)
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $divisi_id =  $div_id;
        $transaksi = 'pengeluaran';

        if ($div_id == 2) {
            $nama = 'Pagelaran';
        } elseif ($div_id == 3) {
            $nama = 'Sekolah Budaya';
        } else {
            $nama = 'Aset';
        }

        // Search 

        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $detail_anggaran = $this->detailAnggaranModel->search($divisi_id, $id, $keyword);
        }/* elseif ($start_date && $end_date) {
             $pemasukan = $this->keuanganModel->rentang_pemasukan($transaksi, $divisi_id, $end_date, $start_date);
         }*/ else {
            $detail_anggaran = $this->detailAnggaranModel->getDetail($divisi_id, $id);
        }

        $data = [
            'title' => 'Sistem informasi Keuangan Puspo Budoyo',
            'detail' => $detail_anggaran,
            'nama_akun' => $this->keuanganModel->nama_akun($transaksi),
            'anggaran' => $this->anggaranModel->getDetailAnggaran($id),
            'nama' => $nama,
            'div_id' => $div_id,
            'id' => $id
        ];

        return view('puspobudoyo/detail_anggaran_page', $data);
    }

    public function edit_detail_anggaran($id_anggaran, $id, $div_id)
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'The Nama field is required.',
                    'min_length[3]' => 'The Nama field must be at least 6 characters in length.',
                    'max_length[255]' => 'The Nama field cannot exceed 255 characters in length.'
                ]
            ],
            'keterangan' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'The Nama field is required.',
                    'min_length[3]' => 'The Nama field must be at least 6 characters in length.',
                    'max_length[255]' => 'The Nama field cannot exceed 255 characters in length.'
                ]
            ],
            'jumlah' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'The Nama field is required.',
                    'Integer' => 'The Jumlah field should be integer'
                ]
            ],
            'nominal' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'The Nama field is required.',
                    'Integer' => 'The Nominal field should be integer'
                ]
            ]

        ])) {

            $validation = session()->setFlashdata('pesan_error', \Config\Services::validation()->listErrors());
            return redirect()->to('/puspobudoyo/detail_anggaran_page/' . $div_id . '/' . $id_anggaran)->withInput()->with('validation', $validation);
        }

        $jumlah = $this->request->getVar('jumlah');
        $nominal = $this->request->getVar('nominal');
        $total = $jumlah * $nominal;

        $this->detailAnggaranModel->save([
            'id' => $id,
            'divisi_id' => $div_id,
            'nama' => $this->request->getVar('nama'),
            'keterangan' => $this->request->getVar('keterangan'),
            'jumlah' => $this->request->getVar('jumlah'),
            'nominal' => $this->request->getVar('nominal'),
            'total' => $total
        ]);

        session()->setFlashdata('pesan', 'Detail Anggaran Berhasil Diubah.');

        return redirect()->to('/puspobudoyo/detail_anggaran_page/' . $div_id . '/' . $id_anggaran);
    }

    public function delete_detail_anggaran($id, $div_id, $id_anggaran)
    {
        if (session()->get('email') == '') {
            session()->setFlashdata('fail_login', 'You are not logged in!');
            return redirect()->to('/homepage/login');
        }

        $this->detailAnggaranModel->delete($id);

        session()->setFlashdata('pesan', 'Data Detail Anggaran Berhasil Dihapus.');
        return redirect()->to('/puspobudoyo/detail_anggaran_page/' . $div_id . '/' . $id_anggaran);
    }

    public function setujui_anggaran($div_id, $id)
    {
        $status = 'Disetujui';

        $this->anggaranModel->save([
            'id' => $id,
            'divisi_id' => $div_id,
            'status' => $status,
        ]);

        session()->setFlashdata('pesan', 'Data Anggaran Berhasil Disetujui.');

        if ($div_id == 2) {
            return redirect()->to('/puspobudoyo/anggaran_pagelaran_page');
        } elseif ($div_id == 3) {
            return redirect()->to('/puspobudoyo/anggaran_sekolah_page');
        } else {
            return redirect()->to('/puspobudoyo/anggaran_aset_page');
        }
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
            'AES' => $this->AES,
            'key' => $this->key,
            'bit' => $this->bit
        ];

        return view('puspobudoyo/profile_page', $data);
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

            $validation = \Config\Services::validation();
            return redirect()->to('/puspobudoyo/profile_page/' . $id)->withInput()->with('validation', $validation);
        }

        $this->penggunaModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'email' => $this->AES->encrypt($this->request->getVar('email'), $this->key, $this->bit),
            'password' => $this->AES->encrypt($this->request->getVar('password'), $this->key, $this->bit),
            'role_id' => session()->get('role_id'),
            'divisi_id' => session()->get('divisi_id')
        ]);

        session()->setFlashdata('pesan', 'Profil Berhasil Diperbarui.');

        return redirect()->to('/puspobudoyo');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/homepage/login');
    }
}
