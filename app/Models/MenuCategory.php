<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuCategory extends Model
{
    use HasFactory;
    protected $table = 'menu_categories';

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

    public function menus()
    {
        return $this->hasMany(Menu::class, 'menu_category_id')->where('status', 1)->orderBy('id');
    }
}
