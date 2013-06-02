<?php
namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class TypeArticle implements InputFilterAwareInterface
{
    public $id;
    public $nom_type;
   
	
    protected $inputFilter; 
    

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->nom_type = (isset($data['nom_type'])) ? $data['nom_type'] : null;             
    }
}