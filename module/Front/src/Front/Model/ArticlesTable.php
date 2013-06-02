<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ArticlesTables extends AbstractTableGateway
{
    // Table name in database
    protected $table ='articles';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Articles());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getArticles($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveArticles(Articles $articles)
    {
        $data = array(
            'id' => $articles->id,
            'nom_article'  => $articles->nom_article, 
			'type_id'  => $articles->type_id
        );

        $id = (int)$articles->id;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getArticles($id)) {
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

    public function deleteArticles($id)
    {
        $this->delete(array('id' => $id));
    }
}