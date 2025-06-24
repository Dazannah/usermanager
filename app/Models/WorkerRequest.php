<?php

namespace App\Models;

use App\Traits\WorkerLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class WorkerRequest
 * 
 * @property int $id
 * 
 * @property WorkerRequestStatus $worker_request_status
 * @property WorkerRequestProcess $worker_request_process
 *
 * @package App\Models
 */

class WorkerRequest extends Model {
    use WorkerLike;

    protected $table = 'worker_requests';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'worker_request_status_id',
        'worker_request_process_id',
        'requester_id',
        'reviewer_id',
        'creator_id',
        'note',
        'technical_note'
    ];

    public function __construct(array $attributes = []) {
        $this->fillable = array_merge($this->getWorkerLikeAttributes(), $this->fillable);

        parent::__construct($attributes);
    }

    public function status() {
        return $this->belongsTo(WorkerRequestStatus::class, 'worker_request_status_id');
    }

    public function process() {
        return $this->belongsTo(WorkerRequestProcess::class, 'worker_request_process_id');
    }

    public function requester() {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function reviewer() {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
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
