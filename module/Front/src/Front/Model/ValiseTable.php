<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Front\Model\Valise;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ValiseTable extends AbstractTableGateway
{
    protected $table ='valise';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Valise());
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


    public function getValise($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveValise(Valise $valise)
    {
         $data = array(
            'voyages_id' => $valise->voyages_id,
            'nom_proprietaire' => $valise->nom_proprietaire,      
        );

        $id = (int)$valise->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($valise->id) {
                $this->update($data, array('id' => $valise->id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function deleteValise($id)
    {
        $this->delete(array('id' => $id));
    }
}