<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function getClient(){
        return $this->belongsTo(Client::class,'client_id');
    }
}
