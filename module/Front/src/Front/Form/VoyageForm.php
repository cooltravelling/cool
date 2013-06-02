<?php
namespace Front\Form;

use Zend\Form\Form;
use Front\Model\TypeVoyageTable;

class VoyageForm extends Form
{
    protected $tvoyageTable = null;

    public function __construct(TypeVoyageTable $tvtable)
    {
        // we want to ignore the name passed
        parent::__construct('voyage');             
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->tvoyageTable = $tvtable;

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'nom_voyages',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nom de votre voyage',
            ),
        ));

         $this->add(array(
            'name' => 'etat_voyages',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Etat de votre voyage',
                'empty_option' => 'Choisir..',
                'value_options' => array(
                            'En cours' => 'En cours',
                            'Terminé' => 'Terminé',
                            'Souhait' => 'Souhait',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'type_id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Type de votre voyage',
                'value_options' => $this->getTypeVoyageOptions(),
                'empty_option'  => 'Choisir..'
            ),
            'attributes' => array(
                'id' => 'typevoyage',
            ),
        ));

        $this->add(array(
            'name' => 'datedebut',
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
            'name' => 'datefin',
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
            'name' => 'user_id',
            'type' => 'Hidden',
             'attributes' => array(
                'id' => 'user_id',
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

    protected function getTypeVoyageOptions()
    {
        $data  = $this->tvoyageTable->fetchAll()->toArray();
        $selectData = array();
            
        foreach ($data as $key => $selectOption) {
            $selectData[$selectOption["id"]] = $selectOption["nom_typev"];
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