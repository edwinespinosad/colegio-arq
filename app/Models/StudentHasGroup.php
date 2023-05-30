<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentHasGroup
 * 
 * @property int $id
 * @property int $fk_id_student
 * @property int $fk_id_group
 * 
 * @property Group $group
 * @property Student $student
 *
 * @package App\Models
 */
class StudentHasGroup extends Model
{
	protected $table = 'student_has_group';
	public $timestamps = false;

	protected $casts = [
		'fk_id_student' => 'int',
		'fk_id_group' => 'int'
	];

	protected $fillable = [
		'fk_id_student',
		'fk_id_group'
	];

	public function group()
	{
		return $this->belongsTo(Group::class, 'fk_id_group');
	}

	public function student()
	{
		return $this->belongsTo(Student::class, 'fk_id_student');
	}
}
