<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Think extends Model
{
    use HasFactory;
    
     protected $table = 'thinks';
     protected $guarded = [];
     protected $recordType = '1';
     protected $fillable = [
    'id',
    'think_title',
    'when',
    'important',
    'about',
    'w_think'
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function photo()
{
    return $this->hasOne(Photo::class);  
}
public function tags() {
    return $this->belongsToMany(Tag::class, 'tag_posts', 'record_id', 'tag_id')
        ->where('record_type', $this->recordType)
        ->withPivot('id');
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
