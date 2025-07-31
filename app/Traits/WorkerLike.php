<?php

namespace App\Traits;

use App\Casts\SanitizedBool;
use App\Casts\SanitizedInt;
use App\Casts\SanitizedString;
use App\Models\Department;

trait WorkerLike {
  protected $commonWorkerCasts = [
    'name' => SanitizedString::class,
    'is_technical' => SanitizedBool::class,
    'registration_number' => SanitizedString::class,
    'post' => SanitizedString::class,
    'department_id' => SanitizedInt::class
  ];

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

  public function getWorkerLikeCasts(): array {
    return $this->commonWorkerCasts;
  }

  public function department() {
    return $this->belongsTo(Department::class, 'department_id');
  }
}
