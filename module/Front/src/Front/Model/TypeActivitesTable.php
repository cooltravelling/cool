<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Front\Model\TypeActivites;


class TypeActivitesTable extends AbstractTableGateway
{
    protected $table ='typeactivites';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new TypeActivites());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function fetchAllToArray()
    {
        $aData = $this->fetchAll()->toArray();
        return $aData;
    }

    public function getTypeActivite($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveTypeActivite(Voyage $voyage)
    {
        $data = array(
            'nom_typeactivite' => $voyage->nom_voyages,
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
}