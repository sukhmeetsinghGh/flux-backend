<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'completed',
        'todo_list_id',
    ];

    public function todoList()
    {
        return $this->belongsTo(TodoList::class, 'todo_list_id', 'id');
    }

    public function user()
    {
        return $this->belongsToThrough(User::class, TodoList::class);
    }
    
}
