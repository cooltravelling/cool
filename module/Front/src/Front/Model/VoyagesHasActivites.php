<?php
namespace Front\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class VoyagesHasActivites
{
    public $voyages_id;
    public $activites_id;
    protected $inputFilter; 

    public function exchangeArray($data)
    {
		$this->voyages_id = (isset($data['voyages_id'])) ? $data['voyages_id'] : null;
		$this->activites_id = (isset($data['activites_id'])) ? $data['activites_id'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}