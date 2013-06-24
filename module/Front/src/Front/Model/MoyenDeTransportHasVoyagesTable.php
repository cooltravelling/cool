<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Front\Model\MoyenDeTransportHasVoyages;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class MoyenDeTransportHasVoyagesTable extends AbstractTableGateway
{
    protected $table ='moyendetransport_has_voyages';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new MoyenDeTransportHasVoyages());
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

    public function getMoyenDeTransportHasVoyages($idmoy, $idvoy)
    {
        $idmoy = (int)$idmoy;
        $idvoy = (int)$idvoy;
        $rowset = $this->select(array(
                    'moyendetransport_id' => $idmoy, 
                    'voyages_id' => $idvoy)
                );
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveMoyenDeTransportHasVoyages(MoyenDeTransportHasVoyages $moyhasvoy)
    {
         $data = array(
            'moyendetransport_id' => $moyhasvoy->moyendetransport_id,
            'voyages_id' => $moyhasvoy->voyages_id,
        );

        $idmoy = (int)$moyhasvoy->moyendetransport_id;
        $idvoy = (int)$moyhasvoy->moyendetransport_id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($moyhasvoy->id) {
                $this->update($data, array(
                    'moyendetransport_id' => $moyhasvoy->moyendetransport_id, 
                    'voyages_id' => $moyhasvoy->voyages_id)
                );
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function deleteMoyenDeTransportHasVoyages($idmoy, $idvoy)
    {
        $this->delete(array(
                    'moyendetransport_id' => $idmoy, 
                    'voyages_id' => $idvoy)
                );
    }
}