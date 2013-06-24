<?php
namespace Front\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class VoyagesHasTypeActivites
{
    public $voyages_id;
    public $typeactivites_id;
    protected $inputFilter; 

    public function exchangeArray($data)
    {
		$this->voyages_id = (isset($data['voyages_id'])) ? $data['voyages_id'] : null;
		$this->typeactivites_id = (isset($data['typeactivites_id'])) ? $data['typeactivites_id'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}