<?php
namespace Front\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class MoyenDeTransportHasVoyages
{
    public $moyendetransport_id;
    public $voyages_id;
    protected $inputFilter; 

    public function exchangeArray($data)
    {
        $this->moyendetransport_id = (isset($data['moyendetransport_id'])) ? $data['moyendetransport_id'] : null;
		$this->voyages_id = (isset($data['voyages_id'])) ? $data['voyages_id'] : null;   
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}