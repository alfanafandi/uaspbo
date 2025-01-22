<?php

require_once 'model/diskon_model.php';
require_once 'model/restoran_model.php';

class controllerDiskon
{
    private $diskonModel;
    private $restoranModel;

    public function __construct(RestoranModel $restoranModel)
    {
        $this->restoranModel = $restoranModel;
        $this->diskonModel = new DiskonModel($restoranModel);
    }

    public function listDiskonsByRestoran($restoran_id)
    {
        $diskons = $this->diskonModel->getDiskonsByRestoran($restoran_id);
        include 'views/restoran/diskon_list.php';
    }

    public function addDiskon($restoran_id, $diskon_nama, $diskon_presentase)
    {
        $this->diskonModel->addDiskon($restoran_id, $diskon_nama, $diskon_presentase);
        header("Location: index.php?modul=diskon");
    }

    public function editById($diskon_id)
    {
        $diskon = $this->diskonModel->getDiskonById($diskon_id);
        include 'views/restoran/diskon_edit.php';
    }

    public function deleteDiskon($diskon_id)
    {
        $this->diskonModel->deleteDiskon($diskon_id);
        header("Location: index.php?modul=diskon&fitur=list&restoran_id=" . $_GET['restoran_id']);
    }

    public function updateDiskon($diskon_id, $restoran_id, $diskon_nama, $diskon_presentase)
    {
        $this->diskonModel->updateDiskon($diskon_id, $restoran_id, $diskon_nama, $diskon_presentase);
        header("Location: index.php?modul=diskon&fitur=list&restoran_id=" . $restoran_id);
    }

    public function getDiskonsByRestoran($restoran_id)
    {
        return $this->diskonModel->getDiskonsByRestoran($restoran_id);
    }
}
