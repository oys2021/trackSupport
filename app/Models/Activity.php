<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Activity extends Model
{
      use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'created_by',
    ];


   public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Updates relationship
    public function updates()
    {
        return $this->hasMany(ActivityUpdate::class);
    }

    public function latestStatus()
    {
        $latestUpdate = $this->updates()->latest()->first();
        return $latestUpdate ? $latestUpdate->status : 'pending';
    }
}
