<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class TypeVoyageHasArticlesTable extends AbstractTableGateway
{
    // Table name in database
    protected $table ='typevoyage_has_articles';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new TypeVoyageHasArticles());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getTypeVoyageHasArticles($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveTypeVoyageHasArticl(TypeVoyageHasArticles $typevoyagehasarticles)
    {
        $data = array(
            'typevoyage_id' => $typevoyagehasarticles->id,
            'articles_id'  => $typevoyagehasarticles->nom_type,
			'nbre_article' => $typevoyagehasarticles->nbre_article,			
			
        );

        $id = (int)$typevoyagehasarticles->id;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getTypeVoyageHasArticles($id)) {
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

    public function deleteTypeVoyageHasArticles($id)
    {
        $this->delete(array('id' => $id));
    }
}