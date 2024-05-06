<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Additional extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function status(){
        if ($this->status) {
            return '<span class="badge badge-primary">Active</span>';
        }else{
            return '<span class="badge badge-danger">NonActive</span>';
        }
    }
    public function type(){
        if ($this->type) {
            return '<span class="badge badge-success">+</span>';
        }else{
            return '<span class="badge badge-danger">-</span>';
        }
    }
}
