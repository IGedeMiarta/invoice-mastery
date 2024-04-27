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
    public function getAdditional(){
        return $this->hasMany(TransactionAdditional::class,'trx_id','id');
    }
    public function getDetails(){
        return $this->hasMany(TransactionDetail::class,'trx_id','id');

    }
    public function getDetailList(){
        return $this->hasMany(TransactionDetailList::class,'trx_id','id');

    }
}
