<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Model\ValiseTable; 
use Front\Form\ValiseForm;
use Front\Model\Valise;
//use Front\Model\ValiseHasArticles;
use Front\Model\Voyage;


class ValiseController extends AbstractActionController
{
	protected $valiseTable;
	protected $voyageTable;

    public function __construct($valise,$voyage)
    {
        $this->valiseTable = $valise;
        $this->voyageTable = $voyage;
    }
	
	public function getValiseTable()
	{
		if (!$this->valiseTable) {
			$sm = $this->getServiceLocator();
			$this->valiseTable = $sm->get('Front\Model\ValiseTable');
		}
		return $this->valiseTable;
	}
	
	 public function getVoyageTable()
    {
        if (!$this->voyageTable) {
            $sm = $this->getServiceLocator();
            $this->voyageTable = $sm->get('Front\Model\VoyageTable');
        }
        return $this->voyageTable;
    }
	
	
	public function setValiseTable($valise)
    {
    	$this->valiseTable = $valise;
    }
    
	public function indexAction()
	{
		return new ViewModel(array(
		'valise' => $this->getValiseTable()->fetchAll($this->getUserId()),
		));
	}

	public function listAction()
    {
        $idvoy = (int) $this->params()->fromRoute('id', 0);
        $lesvalises = $this->getValiseTable()->fetchAllById($idvoy);
        $lesvalises->buffer();
        $results=array();
        
        foreach ($lesvalises as $valise) {
            $voyages = $this->getVoyageTable()->getVoyage($valise->voyages_id);
            $results[] = array('voyages' => $voyages, 'valise' => $valise);
        }

        return new ViewModel(
            array(
                'results' => $results,
                'id' => $idvoy,
            )
        );
        return new ViewModel();
    }

    public function addAction()
    {
    $form = new ValiseForm();
        $form->get('submit')->setValue('Ajouter');
        $idvoy = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $valise = new Valise();
            //$form->setInputFilter($voyage->getInputFilter());
            $form->setData($request->getPost());

             if ($form->isValid()) {
                $valise->exchangeArray($form->getData());
                $this->getValiseTable()->saveValise($valise);
 
                return $this->redirect()->toRoute('valise',array('action'=>'list', 'id' => $valise->voyages_id));
            }
        }
        return array('form' => $form,
            'id'=>$idvoy);
    }
	

	public function editAction()
	{
	}

	public function deleteAction()
	{
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