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
 * @property int $status_id
 * @property string|null $note
 * 
 * @property Status $status
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
		'note',
		'status_id'
	];

	public function departments() {
		return $this->hasMany(Department::class, 'location_id');
	}

	public function status() {
		return $this->belongsTo(Status::class, 'status_id');
	}
}
