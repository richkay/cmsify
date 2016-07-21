<?php

namespace Cmsify;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'cmsify_comments';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
