<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['employee_id', 'manager_id', 'period', 'scores', 'final_score', 'notes'];

    // Supaya kolom 'scores' otomatis menjadi array saat diakses
    protected $casts = [
        'scores' => 'array',
    ];

    public function employee() {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
