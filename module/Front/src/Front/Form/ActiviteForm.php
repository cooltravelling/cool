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
            'name' => 'id',
            'type' => 'Hidden',
            'attributes' => array(
                'id' => 'activites_id',
            ),   
        ));

     	$this->add(array(
            'name' => 'nom_activites',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Type d\'activité',
                'value_options' => $this->getactivitesOptions(),
                'empty_option'  => 'Choisir..'
            ),
            'attributes' => array(
                'id' => 'nom_activites',
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

    protected function getActivitesOptions()
    {
        $data = $this->activiteTable->toArray();
        $selectData = array();
            
        foreach ($data as $key => $selectOption) {
            $selectData[$selectOption["id"]] = $selectOption["nom_activite"];
        }
        return $selectData;
    }
}