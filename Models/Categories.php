<?php
namespace Models;
use Core\Model;

class Categories extends Model{

    public function getList() {
        $array = [];

        $sql="SELECT id, sub,LEFT(name, 10)AS name FROM categories ORDER BY sub DESC";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $item) {
                $item['subs'] = [];
                $array[$item['id']] = $item;
            }

            while ($this->stillNeed($array)) {
                $this->organizeCategory($array);
            }
        }

        return $array;
    }

    public function getCategoryTree($id) {
        $array = [];
        $haveChild = true;

        while($haveChild) {
            $sql = "SELECT * FROM categories WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $sql = $sql->fetch(\PDO::FETCH_ASSOC);
                $array[] = $sql;

                if (!empty($sql['sub'])) {
                   $id = $sql['sub'];
                } else {
                    $haveChild = false;
                }
            }
        }
        $array = array_reverse($array);
        return $array;
    }

    public function getCategoryName($id) {
        $sql="SELECT name FROM categories WHERE id =:id";
        $sql=$this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch(\PDO::FETCH_ASSOC);
            return $sql['name'];
        }
    }

    private function organizeCategory(&$array) {
        foreach ($array as $id => $item) {
            if (isset($array[$item['sub']])) {
                $array[$item['sub']]['subs'][$item['id']] = $item;
                unset($array[$id]);
                break;
            }
        }
    }

    private function stillNeed($array) {
        foreach ($array as $item) {
            if (!empty($item['sub'])) {
                return true;
            }
        }
        return false;
    }

}