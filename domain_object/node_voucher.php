<?php
require_once 'node.php';
class Voucher extends Node
{
    public $voucher_id;
    public $kode;
    public $diskon;

    function __construct($voucher_id, $kode, $diskon)
    {
        parent::__construct($voucher_id);
        $this->voucher_id = $voucher_id;
        $this->kode = $kode;
        $this->diskon = $diskon;
    }
}
