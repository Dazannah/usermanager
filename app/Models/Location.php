<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * 
 * @property int $Id
 * @property string $DisplayName
 * @property string|null $Note
 * 
 * @property Collection|Department[] $departments
 *
 * @package App\Models
 */
class Location extends Model
{
	protected $table = 'Locations';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'DisplayName',
		'Note'
	];

	public function departments()
	{
		return $this->hasMany(Department::class, 'LocationId');
	}
}
