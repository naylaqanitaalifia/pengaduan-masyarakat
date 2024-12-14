<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'histories',
    ];

    protected $casts = [
        'histories' => 'array',
    ];

    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    // public function report() {
    //     return $this->belongsTo(Report::class);
    // }

    public function report()
{
    return $this->hasOneThrough(
        Report::class,  // Model target
        Response::class, // Model perantara
        'id',           // Foreign key di Response
        'id',           // Foreign key di Report
        'response_id',  // Local key di ResponseProgress
        'report_id'     // Local key di Response
    );
}

}
