<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\SanitizedInt;
use App\Casts\SanitizedString;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $displayName
 * @property int $department_manager_id
 * @property string|null $departmentNumber
 * @property string|null $departmentNumber2
 * @property int $location_id
 * @property int $status_id
 * 
 * @property Location $location
 * @property Status $status
 *
 * @package App\Models
 */
class Department extends Model {
	protected $table = 'departments';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'displayName' => SanitizedString::class,
		'department_manager_id' => SanitizedInt::class,
		'departmentNumber' => SanitizedString::class,
		'departmentNumber2' => SanitizedString::class,
		'location_id' => SanitizedInt::class,
		'status_id' => SanitizedInt::class
	];

	protected $fillable = [
		'displayName',
		'department_manager_id',
		'departmentNumber',
		'departmentNumber2',
		'location_id',
		'status_id'
	];

	public function location() {
		return $this->belongsTo(Location::class, 'location_id');
	}

	public function status() {
		return $this->belongsTo(Status::class, 'status_id');
	}

	public function manager() {
		return $this->belongsTo(DepartmentManager::class, 'department_manager_id');
	}
}
