<?php
namespace Front\Form;

use Zend\Form\Form;

class ValiseForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('valise');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'nom_proprietaire',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nom du proprietaire',
            ),
        ));
		
        $this->add(array(
            'name' => 'voyages_id',
            'type' => 'Hidden',
             'attributes' => array(
                'id' => 'voyages_id',
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

    public function populateValues($data)
    {   
        foreach($data as $key=>$row)
        {
           if (is_array(@json_decode($row))){
                $data[$key] = new \ArrayObject(\Zend\Json\Json::decode($row), \ArrayObject::ARRAY_AS_PROPS);
           }
        } 
        parent::populateValues($data);
    }

}