<?php
namespace mywishlist\models;

class Reservation extends \Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $table = "reservation";
    protected $primaryKey = "id,nomParticipant";

    public function reservation(){
        return $this->Hasmany('\mywishlist\models\Reservation', 'nom');
    }

}