<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserList
 *
 * @package App\Models
 */
class userList extends Model
{

    /** @var bool */
    public $timestamps = true;

    /** @var string */
    protected $table = 'lists';

    /** @var array */
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    /** @var array */
    protected $visible = [
        'id',
        'user_id',
        'title',
        'description',
        'created_at',
        'updated_at',
    ];

    /** @var array */
    protected $sortable = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    /** @var array */
    protected $searchable = [
        'title',
        'description',
    ];

    /**
     * User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
