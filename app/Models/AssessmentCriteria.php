<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentCriteria extends Model
{
    protected $fillable = ['name', 'weight', 'description'];
}
