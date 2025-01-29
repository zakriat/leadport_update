<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTicketCountry extends Model
{
    use HasFactory;

    protected $table = "countries";

    protected $fillable = ['name'];
}
