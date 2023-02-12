<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    // Only declared to represent the relationship betweeen the tables
    public function contactHistory()
    {
        return $this->hasMany(ContactHistory::class, 'candidate_id', 'id');
    }
}
