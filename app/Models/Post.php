<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Mix;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
        'deleted_at',
    ];

    // Define relationship to the User model for created, updated, and deleted users

    public function user()
    {
        return $this->belongsTo(User::class, 'created_user_id'); // Adjust if necessary
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_user_id');
    }

    public function search($searchTerm)
    {
        return self::with('user')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('body', 'LIKE', "%{$searchTerm}%");
            })
            ->get();
    }
}
