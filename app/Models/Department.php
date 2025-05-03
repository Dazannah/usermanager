<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $Id
 * @property string|null $DepartmentNumber
 * @property string|null $DepartmentNumber2
 * @property string $DisplayName
 * @property int $LocationId
 * 
 * @property Location $location
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'Departments';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'LocationId' => 'int'
	];

	protected $fillable = [
		'DepartmentNumber',
		'DepartmentNumber2',
		'DisplayName',
		'LocationId'
	];

	public function location()
	{
		return $this->belongsTo(Location::class, 'LocationId');
	}
}
