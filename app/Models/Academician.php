<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academician extends Model
{
    protected $fillable = [
        'name', 'email', 'college', 'department', 'position', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leadingGrants()
    {
        return $this->hasMany(ResearchGrant::class);
    }

    public function researchGrants()
    {
        return $this->belongsToMany(ResearchGrant::class, 'academician_research_grant');
    }
}
