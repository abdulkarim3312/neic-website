<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;
    protected $table = 'attachments';

    protected $guarded = [];

    protected $casts = [
        'entry_time' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(AttachmentCategory::class, 'attachment_id');
    }

    public function user(){
        return $this->belongsTo(Admin::class, 'entry_by', 'id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'entry_by', 'id');
    }
}
