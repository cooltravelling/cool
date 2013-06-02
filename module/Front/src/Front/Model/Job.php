<?php
namespace Front\Model;

class Job
{
    public $id;
    public $ville_depart;
    public $ville_arrivee;
    public $date_debut;
    public $date_fin;
    public $voyage_id;
    public $inputfilter;
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->ville_depart = (isset($data['ville_depart'])) ? $data['ville_depart'] : null;
        $this->ville_arrivee = (isset($data['ville_arrivee'])) ? $data['ville_arrivee'] : null;
        $this->date_debut = (isset($data['date_debut'])) ? $data['date_debut'] : null;
        $this->date_fin = (isset($data['date_fin'])) ? $data['date_fin'] : null;
        $this->voyage_id = (isset($data['voyage_id'])) ? $data['voyage_id'] : null;
    }
}
