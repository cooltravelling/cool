<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Form\ParcoursForm;
use Front\Model\Parcours;
use Front\Model\Voyage;
use Zend\Stdlib\Hydrator;
use AtWeather\Service\Manager;


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
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('parcours', array('action'=>'list', 'id' => $id));
        }

        $parcours = $this->getParcoursTable()->getParcours($id);
        $idvoyage = $parcours->voyage_id;
        $table = $this->getVoyageTable()->fetchAll($this->getUserId());
        $form = new ParcoursForm($table);
        $form->bind($parcours);
        $form->get('submit')->setAttribute('value', 'Modifier');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getParcoursTable()->saveParcours($parcours);

                // Redirect to list of voyages
                return $this->redirect()->toRoute('parcours', array('action'=>'list', 'id' => $idvoyage));
            }
        }
        return array(
            'idvoyage' => $idvoyage,
            'idparcours' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('parcours');
        }
        $parcours = $this->getParcoursTable()->getParcours($id);
        $idvoyage = $parcours->voyage_id;
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');

            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->getParcoursTable()->deleteParcours($id);
            }
            // Redirect to list of parcours
            return $this->redirect()->toRoute('parcours', array('action'=>'list', 'id' => $idvoyage));
        }

        return array(
            'parcours' => $this->getParcoursTable()->getParcours($id),
        );
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