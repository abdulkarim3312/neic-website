<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    protected $casts = [
        'entry_time' => 'datetime',
        'last_update_time' => 'datetime',
    ];

    protected $guarded = [];


    public function user(){
        return $this->belongsTo(Admin::class, 'entry_by', 'id');
    }
    public function category(){
        return $this->belongsTo(ArticleCategory::class, 'article_category_id', 'id');
    }

    public function entryUser()
    {
        return $this->belongsTo(Admin::class, 'entry_by');
    }

    public function updateUser()
    {
        return $this->belongsTo(Admin::class, 'last_update_by');
    }
}
