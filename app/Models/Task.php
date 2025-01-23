<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'task_description',
        'status',
        'created_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
