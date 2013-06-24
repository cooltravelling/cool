<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Form\MoyenDeTransportForm;
use Front\Model\MoyenDeTransport;
use Front\Model\Voyage;
use Front\Model\MoyenDeTransportHasVoyages;
use Zend\Stdlib\Hydrator;


class MoyenDeTransportController extends AbstractActionController
{
    protected $moyenTransportTable;
    protected $voyageTable;
    protected $moyenTransportHasVoyagesTable;

    public function __construct($moyenTransport,$voyage,$moyenTransportHasVoyages)
    {
        $this->moyenTransportTable = $moyenTransport,;
        $this->voyageTable = $voyage;
        $this->moyenTransportHasVoyagesTable = $moyenTransportHasVoyages;
    }

    public function listAction()
    {
    	$idvoy = (int) $this->params()->fromRoute('id', 0);
        $lestransports = $this->getMoyenTransportHasVoyagesTable()->fetchAllById($idvoy);
        $lestransports->buffer();
        $results=array();
        
        foreach ($lestransports as $transport) {
            $transports = $this->getVoyageTable()->getVoyage($transport->voyage_id);
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

    public function getMoyenDeTransportTable()
    {
        if (!$this->moyenTransportTable) {
            $sm = $this->getServiceLocator();
            $this->moyenTransportTable = $sm->get('Front\Model\MoyenDeTransportsTable');
        }
        return $this->moyenTransportTable;
    }

    public function getMoyenTransportHasVoyagesTable()
    {
        if (!$this->moyenTransportTable) {
            $sm = $this->getServiceLocator();
            $this->moyenTransportTable = $sm->get('Front\Model\MoyenDeTransportsTable');
        }
        return $this->moyenTransportTable;
    }

    public function getVoyageTable()
    {
        if (!$this->voyageTable) {
            $sm = $this->getServiceLocator();
            $this->voyageTable = $sm->get('Front\Model\VoyageTable');
        }
        return $this->voyageTable;
    }
}