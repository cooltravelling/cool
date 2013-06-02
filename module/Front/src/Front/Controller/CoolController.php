<?php 
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use RuntimeException;

class CoolController extends AbstractActionController
{
    protected $voyageTable;
    protected $typevoyageTable;
    
    public function __construct($voyage, $typevoyage)
    {
        $this->voyageTable = $voyage;
        $this->typevoyageTable = $typevoyage;
    }
    
    public function setVoyageTable($voyage)
    {
        $this->voyageable = $voyage;
    }
    
    public function setTypeVoyageTable($typevoyage)
    {
        $this->typevoyageTable = $typevoyage;
    }
}