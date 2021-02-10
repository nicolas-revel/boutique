<?php

namespace app\models;

class model
{
    public $elements;
    public $table;

    public function allCategory ()
    {
        $bdd = $this->getBdd();

        $req = $bdd->prepare("SELECT {$this->elements} FROM {$this->table}");
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $result;

    }
}
