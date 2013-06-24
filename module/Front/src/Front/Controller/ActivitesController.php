<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Form\TypeActiviteForm;
use Front\Model\Activites;
use Front\Model\VoyagesHasTypeActivites;
use Zend\Stdlib\Hydrator;
use AtWeather\Service\Manager;


class ActivitesController extends AbstractActionController
{
    protected $activitesTable;
    protected $typeActivitesTable;
    protected $voyageHasTypeActivitesTable;
    protected $voyageHasActivitesTable;

    public function __construct($activites,$voyagetypeact,$typeact,$voyact)
    {
        $this->activitesTable = $activites;
        $this->voyageHasTypeActivitesTable = $voyagetypeact;
        $this->typeActivitesTable = $typeact;
        $this->voyageHasActivitesTable = $voyact;
    }

    public function listAction()
    {
        $idvoy = (int) $this->params()->fromRoute('id', 0);
        $typeactivites = $this->getVoyagesHasTypeActivitesTable()->fetchAllById($idvoy);
        //$activites = $this->getVoyageHasActivitesTable()->fetchAllById($idvoy);
        $typeactivites->buffer();
        $results = array();
     	

        foreach ($typeactivites as $typeact) {
        	
        	//$lesactivites = $this->getActivitesTable()->getActivites($typeact->activites_id);
        	$letypeactivites = $this->getTypeActivitesTable()->getTypeActivite($typeact->typeactivites_id);        	
            //$types[] = array('typeactivites' => $letypeactivites);
            $results[] = array('typeactivites' => $letypeactivites);
        }
    	//var_dump($results);

        return new ViewModel(
            array(
                'results' => $results,
                'idvoyage' => $idvoy,
            )
        );
        
    }

    public function addAction()
    {
        $idvoy = (int) $this->params()->fromRoute('id', 0);
        $table = $this->getTypeActivitesTable()->fetchAll();
        $form = new TypeActiviteForm($table);
        $form->get('submit')->setValue('Ajouter');
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $typeactivite = new VoyagesHasTypeActivites();
            //$form->setInputFilter($typeactivite->getInputFilter());
            $form->setData($request->getPost());

             if ($form->isValid()) {
                $typeactivite->exchangeArray($form->getData());
                $this->getVoyagesHasTypeActivitesTable()->saveVoyagesHasTypeActivites($typeactivite);
                return $this->redirect()->toRoute('activites',array('action'=>'list', 'id' => $idvoy));   
            }
        }
        return array('form' => $form,
            'id' => $idvoy);
    }

    public function addActiviteAction()
    {
        $idtype = (int) $this->params()->fromRoute('id', 0);
        $table = $this->getActivitesTable()->fetchAll($idtype);

        $form = new ActiviteForm($table);
        $form->get('submit')->setValue('Ajouter');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $activites = new VoyageHasActivites();
            //$form->setInputFilter($parcours->getInputFilter());
            $form->setData($request->getPost());

             if ($form->isValid()) {
                $activites->exchangeArray($form->getData());
                $this->getVoyageHasActivitesTable()->saveVoyageHasActivites($activites);
                return $this->redirect()->toRoute('activites',array('action'=>'list', 'id' => $idvoy));   
            }
        }
        return array('form' => $form,
            'id' => $idvoy);
    }
    
    /*
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

    public function getVoyageHasActivitesTable()
    {
        if (!$this->voyageHasActivitesTable) {
            $sm = $this->getServiceLocator();
            $this->voyageHasActivitesTable = $sm->get('Front\Model\VoyageHasActivitesTable');
        }
        return $this->voyageHasActivitesTable;
    }*/

    public function getVoyagesHasTypeActivitesTable()
    {
    	if (!$this->voyageHasTypeActivitesTable) {
            $sm = $this->getServiceLocator();
            $this->voyageHasTypeActivitesTable = $sm->get('Front\Model\VoyagesHasTypeActivitesTable');
        }
        return $this->voyageHasTypeActivitesTable;
    }

    public function VoyageHasActivitesTable()
    {
        if (!$this->voyageHasActivitesTable) {
            $sm = $this->getServiceLocator();
            $this->voyageHasActivitesTable = $sm->get('Front\Model\VoyagesHasActivitesTable');
        }
        return $this->voyageHasActivitesTable;
    }

    public function getTypeActivitesTable()
    {
        if (!$this->typeActivitesTable) {
            $sm = $this->getServiceLocator();
            $this->typeActivitesTable = $sm->get('Front\Model\TypeActivitesTable');
        }
        return $this->typeActivitesTable;
    }

    public function getActivitesTable()
    {
        if (!$this->activitesTable) {
            $sm = $this->getServiceLocator();
            $this->activitesTable = $sm->get('Front\Model\ActivitesTable');
        }
        return $this->activitesTable;
    }
}