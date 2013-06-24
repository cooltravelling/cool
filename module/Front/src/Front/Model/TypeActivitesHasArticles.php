<?php
namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class TypeVoyageHasArticles
{
    public $activites_id;
    public $articles_id;
    protected $inputFilter; 

    public function exchangeArray($data)
    {
        $this->activites_id = (isset($data['activites_id'])) ? $data['activites_id'] : null;
		$this->articles_id = (isset($data['articles_id'])) ? $data['articles_id'] : null;
		$this->nbre_article = (isset($data['nbre_article'])) ? $data['nbre_article'] : null;           
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}