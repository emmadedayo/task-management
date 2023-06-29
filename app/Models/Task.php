<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    //sof delete
    use SoftDeletes;
    protected $fillable = ['task_name', 'task_description', 'task_priority', 'user_id', 'task_start_date','task_due_date','task_status'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
