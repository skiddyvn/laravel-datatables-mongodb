<?php

namespace Pimlie\DataTables\Tests\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';

    static protected $unguarded = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}