<?php
namespace mywishlist\models;

/**
 * Class Item représentant la table Reservation
 * @package mywishlist\models
 */

class Reservation extends \Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $table = "reservation";
    protected $primaryKey = "id,nomParticipant";

    public function reservation(){
        return $this->Hasmany('\mywishlist\models\Reservation', 'nom');
    }

}