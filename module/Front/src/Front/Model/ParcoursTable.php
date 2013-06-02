<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Front\Model\Parcours;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ParcoursTable extends AbstractTableGateway
{
    protected $table ='parcours';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Parcours());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function fetchAllById($idvoy)
    {
        $resultSet = $this->select(array('voyage_id'=>$idvoy));
        return $resultSet;
    }

    public function fetchAllToArray()
    {
        $aData = $this->fetchAll()->toArray();
        return $aData;
    }

    /*
    public function fetchById($idt)
    {
        $id  = (int)$idt;
        $resultSet = $this->select(array('id' => $id));
        return $resultSet;
    }

    public function getNomTypes($id)
    {

        $select = new Select;
        $select->from($this->table);
 
        $where = new  Where();
        $where->equalTo('type_id', $id) ;
        $select->where($where);
        //select nom_typev
        //from voyages,typevoyage
        //where voyages.type_id = typevoyage.type_id
        /*$select = new Select();
        $select->from('typevoyage')
               ->where('type_id = ' . (int)$id);

        $resultSet = $this->select($select);

        return $resultSet;



        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table)
            ->join('typevoyage', 'voyages.type_type = typevoyage.id');
 
        $where = new  Where();
        $where->equalTo('type_id', $id) ;
        $select->where($where);
 
        //you can check your query by echo-ing :
        // echo $select->getSqlString();
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result;
    }*/

    public function getParcours($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveParcours(Parcours $parcours)
    {
         $data = array(
            'ville_depart' => $parcours->ville_depart,
            'ville_arrivee' => $parcours->ville_arrivee,
            'date_debut' => $parcours->date_debut,
            'date_fin' => $parcours->date_fin,
            'voyage_id' => $parcours->voyage_id,
        );

        $id = (int)$parcours->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($parcours->id) {
                $this->update($data, array('id' => $parcours->id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function deleteParcours($id)
    {
        $this->delete(array('id' => $id));
    }
}