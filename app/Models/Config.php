<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Config Column
 * 
 * @property int $id
 * @property string $name
 * @property string $value
 *
 * @package App\Models
 */

class Config extends Model {
    protected $table = 'configs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $casts = [
        'name' => 'string',
        'value' => 'string'
    ];

    protected $fillable = [
        'name',
        'value',
    ];
}
