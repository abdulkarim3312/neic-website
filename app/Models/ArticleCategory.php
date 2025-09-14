<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleCategory extends Model
{
    use HasFactory;
    protected $table = 'article_categories';

    protected $guarded = [];

    protected $casts = [
        'entry_time' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(Admin::class, 'entry_by', 'id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'entry_by', 'id');
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
