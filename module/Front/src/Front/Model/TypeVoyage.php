<?php
namespace Front\Model;

class TypeVoyage
{
    public $id;
    public $nom_typev;

    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nom_typev = (isset($data['nom_typev'])) ? $data['nom_typev'] : null; 
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
