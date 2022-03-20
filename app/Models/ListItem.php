<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserList
 *
 * @package App\Models
 */
class ListItem extends Model
{

    /** @var bool */
    public $timestamps = true;

    /** @var string */
    protected $table = 'items';

    /** @var array */
    protected $fillable = [
        'list_id',
        'title',
        'description',
        'is_done',
    ];

    /** @var array */
    protected $visible = [
        'id',
        'list_id',
        'title',
        'description',
        'is_done',
        'created_at',
        'updated_at',
    ];

    /** @var array */
    protected $sortable = [
        'id',
        'title',
        'is_done',
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
        return $this->belongsTo(User::class, 'list_id', 'id');
    }
}
