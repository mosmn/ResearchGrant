<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'research_grant_id', 'name', 'target_completion_date', 
        'deliverable', 'status', 'remark', 'date_updated'
    ];

    public function researchGrant()
    {
        return $this->belongsTo(ResearchGrant::class);
    }
}
