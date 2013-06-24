<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Front\Model\MoyenDeTransport;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ParcoursTable extends AbstractTableGateway
{
    protected $table ='moyendetransport';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new MoyenDeTransport());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function fetchAllById($id)
    {
        $resultSet = $this->select(array('id'=>$id));
        return $resultSet;
    }

    public function fetchAllToArray()
    {
        $aData = $this->fetchAll()->toArray();
        return $aData;
    }

    public function getMoyenDeTransport($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveMoyenDeTransport(MoyenDeTransport $moytransport)
    {
        $data = array(
            'nom' => $moytransport->nom,
        );

        $id = (int)$moytransport->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($moytransport->id) {
                $this->update($data, array('id' => $moytransport->id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function deleteMoyenDeTransport($id)
    {
        $this->delete(array('id' => $id));
    }
}