<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchGrant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'grant_amount', 'grant_provider', 'duration', 'academician_id'
    ];

    public function projectLeader()
    {
        return $this->belongsTo(Academician::class, 'academician_id');
    }

    public function teamMembers()
    {
        return $this->belongsToMany(Academician::class, 'academician_research_grant');
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
