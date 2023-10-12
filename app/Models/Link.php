<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
    'url',
    ];
    
public function plan()   
{
    return $this->belongsTo(Plan::class);  
}
public function todolist()   
{
    return $this->belongsTo(Todolist::class);  
}
public function think()   
{
    return $this->belongsTo(Think::class);  
}
public function memo()   
{
    return $this->belongsTo(Memo::class);  
}
}
