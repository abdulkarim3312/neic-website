<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublicOpinion extends Model
{
    use HasFactory;

    protected $table = 'public_opinions';

    protected $guarded = [];

    protected $casts = [
        'entry_time' => 'datetime',
        'last_update_time' => 'datetime',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
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
