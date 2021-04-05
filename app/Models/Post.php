<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'message',
        'public',
        'upload_filename',
        'upload_width',
        'upload_height',
    ];

    /**
     * The attributes that should be visible for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'message',
        'upload_filename',
        'upload_width',
        'upload_height',
        'like_num',
        'liked',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'message' => '',
        'patrolled' => 0,
        'upload_filename' => '',
        'upload_width' => 0,
        'upload_height' => 0,
        'source_id' => 0,
        'like_num' => 0,
    ];

    /**
     * @var array
     */
    protected $appends = ['liked'];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * @return bool
     */
    public function getLikedAttribute()
    {
        $likeList = Session::get('like_list', []);
        return isset($likeList[$this->id]);
    }

    /**
     * @return bool
     */
    public function like()
    {
        $likeList = Session::get('like_list', []);
        if (isset($likeList[$this->id])) {
            return false;
        }

        $this->increment('like_num');
        $likeList[$this->id] = true;
        Session::put('like_list', $likeList);
        return true;
    }
}
