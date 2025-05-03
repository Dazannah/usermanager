<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * 
 * @property int $id
 * @property string $name
 * @property string $displayName
 * 
 * @property Collection|AuthItem[] $auth_items
 * @property Collection|Column[] $columns
 * @property Collection|SubAuthItem[] $sub_auth_items
 *
 * @package App\Models
 */
class Status extends Model {
	protected $table = 'statuses';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'displayName'
	];

	public function auth_items() {
		return $this->hasMany(AuthItem::class, 'status_id');
	}

	public function columns() {
		return $this->hasMany(Column::class, 'status_id');
	}

	public function sub_auth_items() {
		return $this->hasMany(SubAuthItem::class, 'status_id');
	}
}
