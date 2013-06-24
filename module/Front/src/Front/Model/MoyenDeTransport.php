<?php
namespace Front\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class MoyenDeTransport
{
    public $id;
    public $nom;
    protected $inputFilter; 
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->nom = (isset($data['nom'])) ? $data['nom'] : null;             
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}