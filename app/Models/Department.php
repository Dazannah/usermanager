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
 * @property string|null $departmentNumber
 * @property string|null $departmentNumber2
 * @property string $displayName
 * @property int $location_id
 * 
 * @property Location $location
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
		'departmentNumber',
		'departmentNumber2',
		'displayName',
		'location_id'
	];

	public function location() {
		return $this->belongsTo(Location::class, 'location_id');
	}
}
