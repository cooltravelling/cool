<?php
namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class TypeVoyageHasArticles
{
    public $typevoyage_id;
    public $article_id;
    protected $inputFilter; 

    public function exchangeArray($data)
    {
        $this->typevoyage_id = (isset($data['typevoyage_id'])) ? $data['typevoyage_id'] : null;
		$this->articles_id = (isset($data['articles_id'])) ? $data['articles_id'] : null;
		$this->nbre_article = (isset($data['nbre_article'])) ? $data['nbre_article'] : null;
                
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}