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

    /**
     * @param string $name Full name of the config ex: app.name
     */
    public static function get_or_create_new_by_name($name): Config {
        return Config::where('name', '=', $name)->first() ?? new Config(
            [
                'name' => $name
            ]
        );
    }
}
