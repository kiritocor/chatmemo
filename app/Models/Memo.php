<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Memo extends Model
{
    use HasFactory;
    
     protected $table = 'memos';
     protected $guarded = [];
     
     protected $fillable = [
    'id',
    'memo_title',
    'about',
    'important',
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
public static function getPaginateByLimit(int $limit_count = 10)
{
    // updated_atで降順に並べたあと、limitで件数制限をかける
$memos = self::orderBy('created_at', 'DESC')->paginate($limit_count);
        
        return $memos;
}
}
