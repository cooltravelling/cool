<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Front\Model\Voyage;


class VoyageTable extends AbstractTableGateway
{
    protected $table ='voyages';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Voyage());
        $this->initialize();
    }

    public function fetchAll($userid)
    {
        $resultSet = $this->select(array('user_id' => $userid));
        return $resultSet;
    }

    public function fetchAllById($idvoy)
    {
        $resultSet = $this->select(array('id' => $idvoy));
        return $resultSet;
    }

    public function fetchAllToArray($idvoy)
    {
        $aData = $this->fetchAllById($idvoy)->toArray();
        return $aData;
    }

    public function getVoyage($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveVoyage(Voyage $voyage)
    {
        $data = array(
            'nom_voyages' => $voyage->nom_voyages,
            'etat_voyages' => $voyage->etat_voyages,
            'datedebut' => $voyage->datedebut,
            'datefin' => $voyage->datefin,
            'user_id' => $voyage->user_id,
            'type_id' => $voyage->type_id,
        );

        $id = (int)$voyage->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($voyage->id) {
                $this->update($data, array('id' => $voyage->id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteVoyage($id)
    {
        $this->delete(array('id' => $id));
    }
    
    public function fetchAllByTypeId($id)
    {
        $select = new Select();
        $select->from('typevoyage')
               ->where('id = ' . (int)$id);

        $resultSet = $this->select($select);
        return $resultSet;
    }
}