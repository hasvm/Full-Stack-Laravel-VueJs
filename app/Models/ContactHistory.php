<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactHistory extends Model
{
    use HasFactory;
    
    public $table = 'contact_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'company_id',
        'candidate_id',
        'contacted',
        'hired'
    ];

    public $timestamps = false;

    // Only declared to represent the relationship betweeen the tables
    public function companies()
    {
        return $this->belongsTo(Company::class, 'id', 'company_id');
    }

    public function candidates()
    {
        return $this->belongsTo(Candidate::class, 'id', 'company_id');
    }
}
