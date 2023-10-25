<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Plan extends Model
{
    use HasFactory;
    
     protected $table = 'plans';
     protected $guarded = [];
     
     protected $fillable = [
    'id',
    'plan_title',
    'where',
    'plan_detail',
    'w_think',
];
     
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tags()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
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
    return $this->orderBy('created_at', 'DESC')->limit($limit_count)->get();
}
}
