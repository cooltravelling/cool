<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ValiseHasArticlesTable extends AbstractTableGateway
{
    // Table name in database
    protected $table ='valise_has_articles';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new ValiseHasArticles());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getValiseHasArticles($id,$valise_id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array(
                                        'valise_id' => $valise_id,
                                        'articles_id' => $id
                                    ));
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

        $articles_id = (int)$valisearticles->articles_id;
        $valise_id_id = (int)$valisearticles->valise_id;

        if ($articles_id == 0) {
            $this->insert($data);
        } elseif ($this->getValiseHasArticles($valise_id,$articles_id)) {
            $this->update(
                $data,
                array(
                    'valise_id' => $valise_id,
                    'articles_id' => $articles_id, 
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteValiseHasArticles($id,$article_id)
    {
        $this->delete(array((
                                'valise_id' => $id,
                                'articles_id' => $article_id,
                            ));
    }
}