<?php
namespace Front\Model;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

class Voyage implements InputFilterAwareInterface
{
    public $id;
    public $nom_voyages;
    public $etat_voyages;
    public $datedebut;
    public $datefin;
    public $user_id;
    public $type_id;
    public $inputFilter;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nom_voyages = (isset($data['nom_voyages'])) ? $data['nom_voyages'] : null;
        $this->etat_voyages = (isset($data['etat_voyages'])) ? $data['etat_voyages'] : null;
        $this->datedebut = (isset($data['datedebut'])) ? $data['datedebut'] : null;
        $this->datefin = (isset($data['datefin'])) ? $data['datefin'] : null;    
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->type_id = (isset($data['type_id'])) ? $data['type_id'] : null;    
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
        
            $inputFilter->add(
                array(
                    'name'     => 'id',
                    'required' => false,
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'type_id',
                    'required' => true,
                )
            );

            $inputFilter->add(
                array(
                    'name' => 'user_id',
                    'required' => true,
                )
            );

            $inputFilter->add(
                array(
                    'name' => 'nom_voyages',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 255,
                            )
                        )
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'etat_voyages',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 255,
                            )
                        ),
                    )
                )
            );
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}
