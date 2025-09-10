<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

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

    public function category(){
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id');
    }
}
