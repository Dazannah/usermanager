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
 * @property int $Id
 * @property string $DisplayName
 * @property int $StatusId
 * @property int $Position
 * 
 * @property Status $status
 * @property Collection|AuthItem[] $auth_items
 *
 * @package App\Models
 */
class Column extends Model
{
	protected $table = 'Columns';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'StatusId' => 'int',
		'Position' => 'int'
	];

	protected $fillable = [
		'DisplayName',
		'StatusId',
		'Position'
	];

	public function status()
	{
		return $this->belongsTo(Status::class, 'StatusId');
	}

	public function auth_items()
	{
		return $this->hasMany(AuthItem::class, 'ColumnId');
	}
}
