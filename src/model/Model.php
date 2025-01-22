<?php

namespace iutnc\hellokant\model;

use Exception;

class Model{

    private array $data;

    public function __construct(?array $data = null){
        $this->data = $data ?? [];
    }

    //construire les accesseurs pour accéder et modifier les valeurs des attributs du modèle. Pour
    //cela, on utilise les méthodes "magic" __get() et __set() (voir la doc php pour des
    //détails).

    public function __get($name){
        return $this->data[$name] ?? null;
    }

    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function delete(): void
    {
        $query = Query::table(static::$table);
        if (isset($this->data['id'])) {
            $query->where('id', '=', $this->data['id'])->delete();
        }
        else{
            throw new Exception('No id to delete');
        }

    }
}