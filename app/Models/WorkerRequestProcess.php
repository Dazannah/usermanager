<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerRequestProcess extends Model {
    protected $table = 'worker_request_processes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'displayName'
    ];

    public function worker_request() {
        return $this->hasMany(WorkerRequest::class, 'worker_request_process_id');
    }
}
