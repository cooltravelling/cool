<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ValiseHasArticlesTable extends AbstractTableGateway
{
    // Table name in database
    protected $table ='valise_has_articles';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new ValiseHasArticles());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getValiseHasArticles($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveValiseHasArticles(ValiseHasArticles $valisearticles)
    {
        $data = array(
            'valise_id' => $valisearticles->valise_id,
            'articles_id'  => $valisearticles->articles_id, 
        );

        $articles_id = (int)$articles->articles_id;

        if ($articles_id == 0) {
            $this->insert($data);
        } elseif ($this->getArticles($articles_id)) {
            $this->update(
                $data,
                array(
                    'articles_id' => $articles_id,
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteValiseHasArticles($id)
    {
        $this->delete(array('id' => $id));
    }
}