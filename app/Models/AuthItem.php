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
 * @property int $Id
 * @property string $DisplayName
 * @property int $ColumnId
 * @property int $StatusId
 * @property int $Position
 * 
 * @property Column $column
 * @property Status $status
 * @property Collection|SubAuthItem[] $sub_auth_items
 *
 * @package App\Models
 */
class AuthItem extends Model
{
	protected $table = 'AuthItems';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'ColumnId' => 'int',
		'StatusId' => 'int',
		'Position' => 'int'
	];

	protected $fillable = [
		'DisplayName',
		'ColumnId',
		'StatusId',
		'Position'
	];

	public function column()
	{
		return $this->belongsTo(Column::class, 'ColumnId');
	}

	public function status()
	{
		return $this->belongsTo(Status::class, 'StatusId');
	}

	public function sub_auth_items()
	{
		return $this->hasMany(SubAuthItem::class, 'AuthItemId');
	}
}
