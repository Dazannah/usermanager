<?php

namespace App\Models;

use App\Casts\SanitizedInt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class DepartmentManager
 * 
 * @property int $id
 *
 * @package App\Models
 */

class DepartmentManager extends Model {
    protected $table = 'department_managers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $casts = [
        'worker_id' => SanitizedInt::class,
        'status_id' => SanitizedInt::class
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'worker_id',
        'status_id'
    ];

    public function worker() {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function departments(): BelongsToMany {
        return $this->BelongsToMany(Department::class);
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
