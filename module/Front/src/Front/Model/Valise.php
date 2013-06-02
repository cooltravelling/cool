<?php
namespace Front\Model;

class Valise
{
    public $id;
    public $voyages_id;
    public $nom_proprietaire;
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->voyages_id = (isset($data['voyages_id'])) ? $data['voyages_id'] : null;
        $this->nom_proprietaire = (isset($data['nom_proprietaire'])) ? $data['nom_proprietaire'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
