<?php
namespace mywishlist\model;
use Illuminate\Database\Eloquent\Model;

class liste extends Model {
    public $timestamps = false;
    protected $primaryKey = "no";
    protected $table = "liste";
}