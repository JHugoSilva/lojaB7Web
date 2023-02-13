<?php
namespace Models;

use Core\Model;

class Brands extends Model {

    public function getList() {
        $array = [];

        $sql="SELECT * FROM brands";
        $sql= $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getNameById($id) {
        $sql = "SELECT name FROM brands WHERE id=:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
            return $data['name'];
        } else {
            return '';
        }
    }
}