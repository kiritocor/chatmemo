<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    
     protected $table = 'plans';
     protected $dates = ['record_at'];
     protected $guarded = [];
     
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function photo()   
{
    return $this->hasOne(Photo::class);  
}
    public function link()   
{
    return $this->hasOne(Link::class);  
}
    public function getByLimit(int $limit_count = 10)
{
    // updated_atで降順に並べたあと、limitで件数制限をかける
    return $this->orderBy('record_at', 'DESC')->limit($limit_count)->get();
}
public function getPaginateByLimit(int $limit_count = 10)
{
    // updated_atで降順に並べたあと、limitで件数制限をかける
    return $this->orderBy('record_at', 'DESC')->paginate($limit_count);
}
}