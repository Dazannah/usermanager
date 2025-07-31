<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\SanitizedInt;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\OrderByPositionScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

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

// global scope added to retrive data always ordered
#[ScopedBy(OrderByPositionScope::class)]
class SubAuthItem extends Model {
	protected $table = 'sub_auth_items';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'authItem_id' => SanitizedInt::class,
		'status_id' => SanitizedInt::class,
		'position' => SanitizedInt::class
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
