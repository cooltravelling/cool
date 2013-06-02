<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Form\ParcoursForm;
use Front\Model\Parcours;
use Front\Model\Voyage;
use Zend\Stdlib\Hydrator;


class ParcoursController extends AbstractActionController
{
    protected $parcoursTable;
    protected $voyageTable;

    public function __construct($parcours,$voyage)
    {
        $this->parcoursTable = $parcours;
        $this->voyageTable = $voyage;
    }

    public function listAction()
    {
        $idvoy = (int) $this->params()->fromRoute('id', 0);
        $lesparcours = $this->getParcoursTable()->fetchAllById($idvoy);
        $lesparcours->buffer();
        $results=array();
        
        foreach ($lesparcours as $parcours) {
            $voyages = $this->getVoyageTable()->getVoyage($parcours->voyage_id);
            $results[] = array('voyages' => $voyages, 'parcours' => $parcours);
        }
    
        return new ViewModel(
            array(
                'results' => $results,
                'idvoyage' => $idvoy,
            )
        );
        
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        $table = $this->getVoyageTable()->fetchAll($this->getUserId());
        $idvoy = (int) $this->params()->fromRoute('id', 0);
        $form = new ParcoursForm($table);
        $form->get('submit')->setValue('Ajouter');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $parcours = new Parcours();
            //$form->setInputFilter($parcours->getInputFilter());
            $form->setData($request->getPost());

             if ($form->isValid()) {
                $parcours->exchangeArray($form->getData());
                $this->getParcoursTable()->saveParcours($parcours);
                return $this->redirect()->toRoute('parcours',array('action'=>'list', 'id' => $parcours->voyage_id));   
            }
        }
        return array('form' => $form,
            'id' => $idvoy);
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function getParcoursTable()
    {
        if (!$this->parcoursTable) {
            $sm = $this->getServiceLocator();
            $this->parcoursTable = $sm->get('Front\Model\ParcoursTable');
        }
        return $this->parcoursTable;
    }

    public function getVoyageTable()
    {
        if (!$this->voyageTable) {
            $sm = $this->getServiceLocator();
            $this->voyageTable = $sm->get('Front\Model\VoyageTable');
        }
        return $this->voyageTable;
    }

    public function getUserId()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $userid=$this->zfcUserAuthentication()->getIdentity()->getId();
        }
        return $userid;
    }
}