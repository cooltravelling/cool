<?php
namespace Front\Form;

use Zend\Form\Form;
use Front\Model\TypeActivitesTable;

class TypeActiviteForm extends Form
{
    protected $typeActiviteTable = null;

    public function __construct($tatable)
    {
        // we want to ignore the name passed
        parent::__construct('typeactivites');             
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->typeActiviteTable = $tatable;

        $this->add(array(
            'name' => 'voyages_id',
            'type' => 'Hidden',
            'attributes' => array(
                'id' => 'voyages_id',
            ),   
        ));

     	$this->add(array(
            'name' => 'typeactivites_id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Type d\'activité',
                'value_options' => $this->getTypeActivitesOptions(),
                'empty_option'  => 'Choisir..'
            ),
            'attributes' => array(
                'id' => 'typeactivites_id',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Enregistrer',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

    protected function getTypeActivitesOptions()
    {
        $data = $this->typeActiviteTable->toArray();
        $selectData = array();
            
        foreach ($data as $key => $selectOption) {
            $selectData[$selectOption["id"]] = $selectOption["nom_typeactivite"];
        }
        return $selectData;
    }
}