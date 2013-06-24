<?php
namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ValiseHasArticles
{
    public $typevoyages_id;
    public $article_id;
    
    protected $inputFilter; 
    

    public function exchangeArray($data)
    {
        $this->typevoyages_id = (isset($data['typevoyages_id'])) ? $data['typevoyages_id'] : null;
        $this->article_id = (isset($data['article_id'])) ? $data['article_id'] : null;       
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}