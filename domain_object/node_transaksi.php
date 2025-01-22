<?php
require_once 'node.php';
class Transaksi extends Node
{
    public $transaksi_id;
    public $nama_pengguna;
    public $jumlah_topup;
    public $status;

    public function __construct($transaksi_id, $nama_pengguna, $jumlah_topup, $status)
    {
        parent::__construct($transaksi_id);
        $this->transaksi_id = $transaksi_id;
        $this->nama_pengguna = $nama_pengguna;
        $this->jumlah_topup = $jumlah_topup;
        $this->status = $status;
    }
}
