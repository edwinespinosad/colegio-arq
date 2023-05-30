<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupHasCourse
 * 
 * @property int $id
 * @property int $fk_id_course
 * @property int $fk_id_group
 * 
 * @property Course $course
 * @property Group $group
 *
 * @package App\Models
 */
class GroupHasCourse extends Model
{
	protected $table = 'group_has_course';
	public $timestamps = false;

	protected $casts = [
		'fk_id_course' => 'int',
		'fk_id_group' => 'int'
	];

	protected $fillable = [
		'fk_id_course',
		'fk_id_group'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'fk_id_course');
	}

	public function group()
	{
		return $this->belongsTo(Group::class, 'fk_id_group');
	}
}
