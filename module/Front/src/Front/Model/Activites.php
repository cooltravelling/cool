<?php
namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Activites
{
    public $id;
    public $nom_activite;
    public $typeactivite_id;
    protected $inputFilter; 

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->nom_activite = (isset($data['nom_activite'])) ? $data['nom_activite'] : null;
        $this->typeactivite_id = (isset($data['typeactivite_id'])) ? $data['typeactivite_id'] : null;  
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}