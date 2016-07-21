<?php

namespace Cmsify;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'cmsify_tags';

    protected $guarded = ['id'];

    public function tags()
    {
        return $this->morphedByMany(Post::class, 'taggable', 'cmsify_taggables', 'tag_id');
    }
}
