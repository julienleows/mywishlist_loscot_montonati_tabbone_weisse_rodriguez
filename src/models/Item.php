<?php
namespace mywishlist\models;

/**
 * Class Item représentant la table Item
 * @package mywishlist\models
 */
class Item extends \Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $table = "item";
    protected $primaryKey = "id";

    public function list() {
        return $this->belongsTo('\mywishlist\models\List', 'liste_id');
    }

}