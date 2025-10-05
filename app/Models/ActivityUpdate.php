<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityUpdate extends Model
{
     use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'status',
        'remark',
    ];

     public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // Link to User who made the update
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
