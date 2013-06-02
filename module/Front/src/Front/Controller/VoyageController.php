<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Form\VoyageForm;
use Front\Model\Voyage;
use Front\Model\TypeVoyage;


class VoyageController extends AbstractActionController
{
	protected $voyageTable;
	protected $tvoyageTable;

    public function __construct($voyage, $typevoyage)
    {
        $this->voyageTable = $voyage;
        $this->tvoyageTable = $typevoyage;
    }
	
	public function getVoyageTable()
	{
		if (!$this->voyageTable) {
			$sm = $this->getServiceLocator();
			$this->voyageTable = $sm->get('Front\Model\VoyageTable');
		}
		return $this->voyageTable;
	}

	public function getTypeVoyageTable()
	{
		if (!$this->tvoyageTable) {
			$sm = $this->getServiceLocator();
			$this->tvoyageTable = $sm->get('Front\Model\TypeVoyageTable');
		}
		return $this->tvoyageTable;
	}
	
	public function setVoyageTable($voyage)
    {
    	$this->voyageTable = $voyage;
    }
    
	public function indexAction()
	{
		$voyages = $this->getVoyageTable()->fetchAll($this->getUserId());
		$voyages->buffer();

		$results=array();
		
		foreach ($voyages as $voyage) {
            $type = $this->getTypeVoyageTable()->getTypeVoyage($voyage->type_id);
            $results[] = array('type' => $type, 'voyages' => $voyage);
		}
	
        return new ViewModel(
            array(
                'results' => $results,
            )
        );
	}

	public function addAction()
	{
		$form = new VoyageForm($this->getTypeVoyageTable());
        $form->get('submit')->setValue('Ajouter');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $voyage = new Voyage();
            $form->setInputFilter($voyage->getInputFilter());
            $form->setData($request->getPost());

             if ($form->isValid()) {
                $voyage->exchangeArray($form->getData());
                $this->getVoyageTable()->saveVoyage($voyage);
 
                return $this->redirect()->toRoute('voyage');
            }
        }
        return array('form' => $form);
	}

	public function editAction()
	{
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('voyage', array('action'=>'add'));
        }
        $voyage = $this->getVoyageTable()->getVoyage($id);
        $form = new VoyageForm($this->getTypeVoyageTable());
        $form->bind($voyage);
        $form->get('submit')->setAttribute('value', 'Modifier');
        $idvoyage = $voyage->id;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getVoyageTable()->saveVoyage($voyage);

                // Redirect to list of voyages
                return $this->redirect()->toRoute('voyage');
            }
        }

        return array(
            'id' => $idvoyage,
            'form' => $form,
        );
    }

	public function deleteAction()
	{
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('voyage');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getVoyageTable()->deleteVoyage($id);
            }
            // Redirect to list of voyages
            return $this->redirect()->toRoute('voyage');
        }

        return array(
            'id'    => $id,
            'voyage' => $this->getVoyageTable()->getVoyage($id)
        );
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