<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ([
        'report_id',
        'response_status',
        'staff_id'
    ]);

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function progress()
    {
        return $this->hasOne(ResponseProgress::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
