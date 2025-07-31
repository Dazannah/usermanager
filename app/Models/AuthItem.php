<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\SanitizedBool;
use App\Casts\SanitizedInt;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\OrderByPositionScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

/**
 * Class AuthItem
 * 
 * @property int $id
 * @property string $displayName
 * @property int $column_id
 * @property int $status_id
 * @property int $position
 * @property bool $is_ldap
 * 
 * @property Column $column
 * @property Status $status
 * @property Collection|SubAuthItem[] $sub_auth_items
 *
 * @package App\Models
 */

// global scope added to retrive data always ordered
#[ScopedBy(OrderByPositionScope::class)]
class AuthItem extends Model {
	protected $table = 'authItems';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'column_id' => SanitizedInt::class,
		'status_id' => SanitizedInt::class,
		'position' => SanitizedInt::class,
		'is_ldap' => SanitizedBool::class
	];

	protected $fillable = [
		'displayName',
		'column_id',
		'status_id',
		'position',
		'is_ldap'
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
