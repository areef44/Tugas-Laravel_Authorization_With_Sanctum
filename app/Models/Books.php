<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    //guard declaration
    protected $guarded = ['id'];

    //primary key declaration
    protected $primaryKey = 'id';
}
