<?php

namespace App\Models;

use App\Models\User;
use App\Models\StaffProvinces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'province',
        'regency',
        'subdistrict',
        'village',
        'type',
        'description',
        'image',
        'statement',
    ];

    protected $casts = [
        'voting' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function response() {
        return $this->hasMany(Response::class, 'report_id');  // kalo di lain error berarti ganti jadi response
    }    

    // public function response()
    // {
    //     return $this->belongsTo(Response::class);
    // }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function staffProvince() {
        return $this->belongsTo(StaffProvinces::class, 'province');
    }

    public function progress()
    {
        return $this->hasManyThrough(
            ResponseProgress::class, // Model target
            Response::class,         // Model perantara
            'report_id',             // Foreign key di Response
            'response_id',           // Foreign key di ResponseProgress
            'id',                    // Local key di Report
            'id'                     // Local key di Response
        );
    }

    // public function progress()
    // {
    //     return $this->hasMany(ResponseProgress::class, 'report_id');
    // }

    public function voteButton($userId) {
        $voting = $this->voting;
        if (in_array($userId, $voting)) {
            $this->voting = array_diff($voting, [$userId]);
        } else {
            $this->voting[] = $userId;
        }
    }
}
