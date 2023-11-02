<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagPost extends Model
{
public function think()
{
    return $this->belongsTo(Think::class, 'record_id', 'id')->where('record_type', '1');
}

public function memo()
{
    return $this->belongsTo(Memo::class, 'record_id', 'id')->where('record_type', '4');
}

public function todolist()
{
    return $this->belongsTo(Todolist::class, 'record_id', 'id')->where('record_type', '2');
}

public function plan()
{
    return $this->belongsTo(Plan::class, 'record_id', 'id')->where('record_type', '3');
}

}
