<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentReply extends Model
{
    use SoftDeletes;

    protected $table = 'comments_reply';

    protected $fillable = [
        'comment_id',
        'reviewer',
        'content',
        'reaction',
        'status'
    ];
}
