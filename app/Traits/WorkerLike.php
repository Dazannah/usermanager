<?php

namespace App\Traits;

use App\Models\Department;

trait WorkerLike {
  protected $commonWorkerAttributes = [
    'name',
    'is_technical',
    'registration_number',
    'post',
    'department_id'
  ];

  public function getWorkerLikeAttributes(): array {
    return $this->commonWorkerAttributes;
  }

  public function department() {
    return $this->belongsTo(Department::class, 'department_id');
  }
}
