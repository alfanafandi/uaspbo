<?php
require_once __DIR__ . '/../domain_object/node_menu.php';
require_once __DIR__ . '/../domain_object/node_restoran.php';
require_once __DIR__ . '/../domain_object/searchable.php';

class MenuModel implements Searchable
{
    private $db;
    private $restoranModel;

    public function __construct(RestoranModel $restoranModel)
    {
        $this->restoranModel = $restoranModel;
        $this->db = new mysqli('localhost', 'root', '', 'ProjectDB');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function addMenu($restoran_id, $menu_nama, $menu_kategori, $menu_harga, $menu_gambar)
    {
        $stmt = $this->db->prepare("INSERT INTO menus (restoran_id, menu_nama, menu_kategori, menu_harga, menu_gambar) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $restoran_id, $menu_nama, $menu_kategori, $menu_harga, $menu_gambar);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllMenus()
    {
        $result = $this->db->query("SELECT * FROM menus");
        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $row['restoran'] = $this->restoranModel->getRestoranById($row['restoran_id']);
            $menus[] = new Makanan($row['menu_id'], $row['restoran_id'], $row['menu_nama'], $row['menu_kategori'], $row['menu_harga'], $row['menu_gambar'], $row['restoran']);
        }
        return $menus;
    }

    public function getMenuById($menu_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM menus WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $menu = $result->fetch_assoc();
        $stmt->close();
        if ($menu) {
            $menu['restoran'] = $this->restoranModel->getRestoranById($menu['restoran_id']);
            return new Makanan($menu['menu_id'], $menu['restoran_id'], $menu['menu_nama'], $menu['menu_kategori'], $menu['menu_harga'], $menu['menu_gambar'], $menu['restoran']);
        }
        return null;
    }

    public function getMenusByRestoran($restoran_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM menus WHERE restoran_id = ?");
        $stmt->bind_param("i", $restoran_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $row['restoran'] = $this->restoranModel->getRestoranById($row['restoran_id']);
            $menus[] = new Makanan($row['menu_id'], $row['restoran_id'], $row['menu_nama'], $row['menu_kategori'], $row['menu_harga'], $row['menu_gambar'], $row['restoran']);
        }
        $stmt->close();
        return $menus;
    }

    public function updateMenu($menu_id, $restoran_id, $menu_nama, $menu_kategori, $menu_harga, $menu_gambar)
    {
        $stmt = $this->db->prepare("UPDATE menus SET restoran_id = ?, menu_nama = ?, menu_kategori = ?, menu_harga = ?, menu_gambar = ? WHERE menu_id = ?");
        $stmt->bind_param("issssi", $restoran_id, $menu_nama, $menu_kategori, $menu_harga, $menu_gambar, $menu_id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteMenu($menu_id)
    {
        $stmt = $this->db->prepare("DELETE FROM menus WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        $stmt->close();
    }

    public function getMenuByName($menu_nama)
    {
        $stmt = $this->db->prepare("SELECT * FROM menus WHERE menu_nama = ?");
        $stmt->bind_param("s", $menu_nama);
        $stmt->execute();
        $result = $stmt->get_result();
        $menu = $result->fetch_assoc();
        $stmt->close();
        if ($menu) {
            $menu['restoran'] = $this->restoranModel->getRestoranById($menu['restoran_id']);
            return new Makanan($menu['menu_id'], $menu['restoran_id'], $menu['menu_nama'], $menu['menu_kategori'], $menu['menu_harga'], $menu['menu_gambar'], $menu['restoran']);
        }
        return null;
    }

    public function searchByName($query)
    {
        $stmt = $this->db->prepare("SELECT * FROM menus WHERE menu_nama LIKE ?");
        $likeQuery = '%' . $query . '%';
        $stmt->bind_param("s", $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $row['restoran'] = $this->restoranModel->getRestoranById($row['restoran_id']);
            $menus[] = new Makanan($row['menu_id'], $row['restoran_id'], $row['menu_nama'], $row['menu_kategori'], $row['menu_harga'], $row['menu_gambar'], $row['restoran']);
        }
        $stmt->close();
        return $menus;
    }
}
