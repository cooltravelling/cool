<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class TypeArticleTable extends AbstractTableGateway
{
    // Table name in database
    protected $table ='typearticle';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new TypeArticle());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getTypeArticle($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveTypeArticle(TypeArticle $articles)
    {
        $data = array(
            'id' => $typearticles->id,
            'nom_type'  => $typearticles->nom_type, 
			
        );

        $id = (int)$typearticle->id;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getTypeArticle($id)) {
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

    public function deleteTypeArticle($id)
    {
        $this->delete(array('id' => $id));
    }
}