<?php

namespace Anil\ErdGenerator\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Anil\ErdGenerator\Tests\Traits\HasComments;

class Post extends Model
{
    use HasComments;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
