<?php
namespace mywishlist\model;

class Item extends \Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $table = "item";
    protected $primaryKey = "id";
}