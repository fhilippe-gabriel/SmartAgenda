<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'client_name',
        'service',
        'scheduled_at',
    ];
    public function user()
    {
        // Define que este agendamento pertence a um usuário
        return $this->belongsTo(User::class);
    }
}
