<?php
namespace mywishlist\models;

class Liste extends \Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $table = "liste";
    protected $primaryKey = "no";

    public function items() {
        return $this->Hasmany('\mywishlist\models\Item', 'liste_id');
    }
}