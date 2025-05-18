<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Column
 * 
 * @property int $id
 * @property string $displayName
 * @property int $status_id
 * @property int $position
 * 
 * @property Status $status
 * @property Collection|AuthItem[] $auth_items
 *
 * @package App\Models
 */
class Column extends Model {
	protected $table = 'columns';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'status_id' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'displayName',
		'status_id',
		'position'
	];

	public function status() {
		return $this->belongsTo(Status::class, 'status_id');
	}

	public function auth_items() {
		return $this->hasMany(AuthItem::class, 'column_id');
	}

	public static function all_sorted_auth_items_by_position() {
		$columns = Column::all();

		$columns = $columns->sortBy('position');

		foreach ($columns as $column) {
			$column->auth_items = $column->auth_items->sortBy('position');
		}

		return $columns;
	}
}
