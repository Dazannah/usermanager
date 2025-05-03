<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthItem
 * 
 * @property int $id
 * @property string $displayName
 * @property int $column_id
 * @property int $status_id
 * @property int $position
 * 
 * @property Column $column
 * @property Status $status
 * @property Collection|SubAuthItem[] $sub_auth_items
 *
 * @package App\Models
 */
class AuthItem extends Model {
	protected $table = 'authItems';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'column_id' => 'int',
		'status_id' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'displayName',
		'column_id',
		'status_id',
		'position'
	];

	public function column() {
		return $this->belongsTo(Column::class, 'column_id');
	}

	public function status() {
		return $this->belongsTo(Status::class, 'status_id');
	}

	public function sub_auth_items() {
		return $this->hasMany(SubAuthItem::class, 'authItem_id');
	}
}
