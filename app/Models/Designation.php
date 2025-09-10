<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory;
    protected $table = 'designations';

    protected $guarded = [];

    protected $casts = [
        'entry_time' => 'datetime',
    ];

    public function committeeMembers()
    {
        return $this->hasMany(CommitteeMemberInfo::class, 'designation_id');
    }

    public function user(){
        return $this->belongsTo(Admin::class, 'entry_by', 'id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'entry_by', 'id');
    }
}
