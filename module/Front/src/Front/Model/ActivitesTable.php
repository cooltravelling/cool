<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Front\Model\Activites;

class ActivitesTable extends AbstractTableGateway
{
    // Table name in database
    protected $table ='activites';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Activites());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getActivites($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveActivites(Activites $activites)
    {
        $data = array(
            'nom_activite'  => $activites->nom_activite, 
			'typeactivite_id'  => $activites->typeactivite_id
        );

        $id = (int)$activites->id;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getActivites($id)) {
            $this->update(
                $data,
                array(
                    'id' => $id,
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteActivites($id)
    {
        $this->delete(array('id' => $id));
    }
}