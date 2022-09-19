<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Audit.
 *
 * @version September 18, 2021, 7:02 pm UTC
 *
 * @property string $user_type
 * @property int $user_id
 * @property string $event
 * @property string $auditable_type
 * @property int $auditable_id
 * @property string $old_values
 * @property string $new_values
 * @property string $url
 * @property string $ip_address
 * @property string $user_agent
 * @property string $tags
 */
class Audit extends Model
{
    use HasFactory;

    public $table = 'audits';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $connection = 'mysql';

    public $fillable = [
        'user_type',
        'user_id',
        'event',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'tags',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_type' => 'string',
        'user_id' => 'integer',
        'event' => 'string',
        'auditable_type' => 'string',
        'auditable_id' => 'integer',
        'old_values' => 'string',
        'new_values' => 'string',
        'url' => 'string',
        'ip_address' => 'string',
        'user_agent' => 'string',
        'tags' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'user_type' => 'nullable|string|max:255',
        'user_id' => 'nullable',
        'event' => 'required|string|max:255',
        'auditable_type' => 'required|string|max:255',
        'auditable_id' => 'required',
        'old_values' => 'nullable|string',
        'new_values' => 'nullable|string',
        'url' => 'nullable|string',
        'ip_address' => 'nullable|string|max:45',
        'user_agent' => 'nullable|string|max:1023',
        'tags' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];
}
