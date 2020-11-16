<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communicationmessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender',
        'receiver',
        'communicationmessage',
        'is_viewed'
    ];
}
