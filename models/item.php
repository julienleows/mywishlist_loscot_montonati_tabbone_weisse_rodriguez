<?php
namespace mywishlist\model;
use Illuminate\Database\Eloquent\Model;

class item extends Model {
    public $timestamps = false;
    protected $table = "item";
    protected $primaryKey = "id";

}