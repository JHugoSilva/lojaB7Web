<?php

namespace Models;

use Core\Model;

class Options extends Model {

    public function getName($id) {
        $sql = "SELECT name FROM options WHERE id=:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch(\PDO::FETCH_ASSOC);
            return $sql['name'];
        }
    }
}