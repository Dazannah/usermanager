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
 * @property int $Id
 * @property string $Name
 * @property string $DisplayName
 * 
 * @property Collection|AuthItem[] $auth_items
 * @property Collection|Column[] $columns
 * @property Collection|SubAuthItem[] $sub_auth_items
 *
 * @package App\Models
 */
class Status extends Model
{
	protected $table = 'Status';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'Name',
		'DisplayName'
	];

	public function auth_items()
	{
		return $this->hasMany(AuthItem::class, 'StatusId');
	}

	public function columns()
	{
		return $this->hasMany(Column::class, 'StatusId');
	}

	public function sub_auth_items()
	{
		return $this->hasMany(SubAuthItem::class, 'StatusId');
	}
}
