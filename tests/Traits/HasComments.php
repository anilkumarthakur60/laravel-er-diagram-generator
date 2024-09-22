<?php

namespace Anil\ErdGenerator\Tests\Traits;

use Anil\ErdGenerator\Tests\Models\Comment;

trait HasComments
{

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
