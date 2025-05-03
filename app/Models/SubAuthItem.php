<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubAuthItem
 * 
 * @property int $Id
 * @property string $DisplayName
 * @property int $AuthItemId
 * @property int $StatusId
 * @property int $Position
 * 
 * @property AuthItem $auth_item
 * @property Status $status
 *
 * @package App\Models
 */
class SubAuthItem extends Model
{
	protected $table = 'SubAuthItems';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'AuthItemId' => 'int',
		'StatusId' => 'int',
		'Position' => 'int'
	];

	protected $fillable = [
		'DisplayName',
		'AuthItemId',
		'StatusId',
		'Position'
	];

	public function auth_item()
	{
		return $this->belongsTo(AuthItem::class, 'AuthItemId');
	}

	public function status()
	{
		return $this->belongsTo(Status::class, 'StatusId');
	}
}
