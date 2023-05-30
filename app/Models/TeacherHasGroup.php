<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TeacherHasGroup
 * 
 * @property int $id
 * @property int $fk_id_teacher
 * @property int $fk_id_group
 * 
 * @property Group $group
 * @property Teacher $teacher
 *
 * @package App\Models
 */
class TeacherHasGroup extends Model
{
	protected $table = 'teacher_has_group';
	public $timestamps = false;

	protected $casts = [
		'fk_id_teacher' => 'int',
		'fk_id_group' => 'int'
	];

	protected $fillable = [
		'fk_id_teacher',
		'fk_id_group'
	];

	public function group()
	{
		return $this->belongsTo(Group::class, 'fk_id_group');
	}

	public function teacher()
	{
		return $this->belongsTo(Teacher::class, 'fk_id_teacher');
	}
}
