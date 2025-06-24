<?php

namespace App\Models;

use App\Traits\WorkerLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Worker
 * 
 * @property int $id
 * @property string $name
 * @property bool $is_technical
 * @property string $registration_number
 * @property string $post
 * @property string $department_leader
 * 
 * @property Collection|AuthItem[] $auth_items
 * @property Collection|SubAuthItem[] $sub_auth_items
 * @property Collection|Status $status
 *
 * @package App\Models
 */

class Worker extends Model {
    use WorkerLike;

    protected $table = 'workers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [];

    public function __construct(array $attributes = []) {
        $this->fillable = array_merge($this->getWorkerLikeAttributes(), $this->fillable);

        parent::__construct($attributes);
    }

    public function auth_items(): BelongsToMany {
        return $this->BelongsToMany(AuthItem::class);
    }

    public function sub_auth_items(): BelongsToMany {
        return $this->BelongsToMany(SubAuthItem::class);
    }

    public function departments(): BelongsToMany {
        return $this->BelongsToMany(Department::class);
    }
}
