<?php

namespace App\Traits;

trait WorkerLike {
  protected $commonWorkerAttributes = [
    'name',
    'is_technical',
    'registration_number',
    'post',
    'department_leader',
    'status_id'
  ];

  public function getWorkerLikeAttributes(): array {
    return $this->commonWorkerAttributes;
  }
}
