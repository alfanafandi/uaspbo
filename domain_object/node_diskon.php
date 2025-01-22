<?php
require_once 'node.php';
class Diskon extends Node
{
    public $diskon_id;

    public $diskon_restoran;
    public $diskon_nama;

    public $diskon_presentase;

    function __construct($diskon_id, $diskon_restoran, $diskon_nama, $diskon_presentase)
    {
        parent::__construct($diskon_id);
        $this->diskon_id = $diskon_id;
        $this->diskon_restoran = $diskon_restoran;
        $this->diskon_nama = $diskon_nama;
        $this->diskon_presentase = $diskon_presentase;
    }
}
