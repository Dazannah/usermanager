<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubAuthItem
 * 
 * @property int $id
 * @property string $displayName
 * @property int $authItem_id
 * @property int $status_id
 * @property int $position
 * 
 * @property AuthItem $auth_item
 * @property Status $status
 *
 * @package App\Models
 */
class SubAuthItem extends Model {
	protected $table = 'subAuthItems';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'authItem_id' => 'int',
		'status_id' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'displayName',
		'authItem_id',
		'status_id',
		'position'
	];

	public function auth_item() {
		return $this->belongsTo(AuthItem::class, 'authItem_id');
	}

	public function status() {
		return $this->belongsTo(Status::class, 'status_id');
	}
}
