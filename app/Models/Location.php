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
 * @property int $id
 * @property string $displayName
 * @property string|null $note
 * 
 * @property Collection|Department[] $departments
 *
 * @package App\Models
 */
class Location extends Model {
	protected $table = 'locations';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'displayName',
		'note'
	];

	public function departments() {
		return $this->hasMany(Department::class, 'location_id');
	}
}
