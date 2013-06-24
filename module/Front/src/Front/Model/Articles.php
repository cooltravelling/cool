<?php
namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Articles
{
    public $id;
    public $nom_article;
    public $type_id;
    protected $inputFilter; 
    

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->nom_article = (isset($data['nom_article'])) ? $data['nom_article'] : null;
        $this->type_id = (isset($data['type_id'])) ? $data['type_id'] : null;         
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}