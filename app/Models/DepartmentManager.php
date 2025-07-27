<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class DepartmentManager
 * 
 * @property int $id
 * @property string $note
 * 
 * @property Collection|Department[] $auth_items
 *
 * @package App\Models
 */

class DepartmentManager extends Model {
    protected $table = 'department_managers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'note',
        'worker_id'
    ];

    public function process() {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function departments(): BelongsToMany {
        return $this->BelongsToMany(Department::class);
    }
}
