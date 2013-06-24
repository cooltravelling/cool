<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Front\Model\VoyagesHasActivites;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class VoyagesHasActivitesTable extends AbstractTableGateway
{
    protected $table ='voyages_has_activites';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new VoyagesHasActivites());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function fetchAllById($idvoy)
    {
        $resultSet = $this->select(array('voyages_id'=>$idvoy));
        return $resultSet;
    }

    public function fetchAllToArray()
    {
        $aData = $this->fetchAll()->toArray();
        return $aData;
    }

    public function getVoyageHasTypeActivites($idvoy,$idact)
    {
        $idvoy = (int)$idvoy;
        $idact = (int)$idact;
        $rowset = $this->select(array(
                        'voyages_id' => $idvoy,
                        'activites_id' => $idact
                    )
                );
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveVoyagesHasActivites(VoyagesHasActivites $voyhasact)
    {
        $data = array(
            'voyages_id' => $voyhasact->voyages_id,
            'activites_id' => $voyhasact->typeactivites_id,
        );

        $idvoy = (int)$voyhasact->voyages_id;
        $idtype = (int)$voyhasact->typeactivites_id;

        var_dump($idvoy + $idtype);
        $this->insert($data);
        /*
        if ($voyhasact->voyages_id && $voyhasact->typeactivites_id) {
            throw new \Exception('Vous avez déjà ce type d\'activité');
        } else {
            $this->insert($data);
        }*/
        
    }
    
    public function deleteVoyagesActivites($idvoy,$idact)
    {
        $this->delete(array(
                    'voyages_id' => $idvoy, 
                    'activites_id' => $idact)
                );
    }
}