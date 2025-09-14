<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommitteeMemberInfo extends Model
{
    use HasFactory;

    protected $table = 'committee_member_infos';

    protected $guarded = [];

    protected $casts = [
        'entry_time' => 'datetime',
        'last_update_time' => 'datetime',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function category()
    {
        return $this->belongsTo(MemberCategory::class, 'member_category_id');
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
