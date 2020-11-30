<?php
namespace mywishlist\model;

class Liste extends \Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $table = "liste";
    protected $primaryKey = "no";

}