<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Only declared to represent the relationship betweeen the tables
    public function contactHistory()
    {
        return $this->hasMany(ContactHistory::class, 'company_id', 'id');
    }
}
