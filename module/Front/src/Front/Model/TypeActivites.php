<?php
namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class TypeActivites
{
    public $id;
    public $nom_typeactivite;
    protected $inputFilter; 
    

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->nom_typeactivite = (isset($data['nom_typeactivite'])) ? $data['nom_typeactivite'] : null; 
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}