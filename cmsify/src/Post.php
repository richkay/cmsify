<?php

namespace Cmsify;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'cmsify_posts';

    protected $guarded = ['id'];

    const STATE_DRAFT = 'draft';

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable', 'cmsify_categoryables', 'categoryable_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
