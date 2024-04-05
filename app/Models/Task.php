<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "text",
        "finished",
        "category_id"
    ];

    /*
    * Get the task category.
    */
    public function category(): HasMany
    {
        return $this->belongsTo(Category::class);
    }
}
