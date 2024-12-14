<?php

namespace App\Models;

use App\Models\User;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffProvinces extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'province'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function user() {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // // Relasi dengan Report
    // public function reports() {
    //     return $this->hasMany(Report::class, 'province', 'province');
    // }
}
