<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $displayName
 * @property string $manager
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
		'location_id' => 'int'
	];

	protected $fillable = [
		'displayName',
		'manager',
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
}
