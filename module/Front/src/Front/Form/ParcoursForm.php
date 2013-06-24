<?php
namespace Front\Form;

use Zend\Form\Form;
use Front\Model\VoyageTable;

class ParcoursForm extends Form
{
    protected $voyageTable = null;

    public function __construct($vtable)
    {
        // we want to ignore the name passed
        parent::__construct('parcours');             
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->voyageTable = $vtable;

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

       $this->add(array(
            'name' => 'voyage_id',
            'type' => 'Hidden',
             'attributes' => array(
                'id' => 'voyage_id',
            ),   
        ));

        $this->add(array(
            'name' => 'ville_depart',
            'type' => 'Text',
            'options' => array(
                'label' => 'Ville de départ',
            ),
        ));

        $this->add(array(
            'name' => 'ville_arrivee',
            'type' => 'Text',
            'options' => array(
                'label' => 'Ville d\'arrivée',
            ),
        ));

        $this->add(array(
            'name' => 'date_debut',
            'attributes' =>array(
                'type' => 'Zend\Form\Element\Date',
                'id' => 'date1',
                'class' =>'datepick',
            ),
            'options' => array(
                'label' => 'Date Début',
                'format' => 'd-m-Y',
            ),
        ));

        $this->add(array(
            'name' => 'date_fin',
            'attributes' =>array(
                'type' => 'Zend\Form\Element\Date',
                'id' => 'date2',
                'class' => 'datepick'
            ),
            'options' => array(
                'label' => 'Date Fin',
                'format' => 'd-m-Y',
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

    protected function getVoyageOptions()
    {
        $data = $this->voyageTable->toArray();
        $selectData = array();
            
        foreach ($data as $key => $selectOption) {
            $selectData[$selectOption["id"]] = $selectOption["nom_voyages"];
        }
        return $selectData;
    }

    public function populate($data)
    {
        foreach($data as $key=>$row)
        {
           if (is_array(@json_decode($row))){
                $data[$key] = new \ArrayObject(\Zend\Json\Json::decode($row), \ArrayObject::ARRAY_AS_PROPS);
           }
        } 
        parent::populate($data);
    }
}