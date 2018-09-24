<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostModel extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'description',
    ];
}
