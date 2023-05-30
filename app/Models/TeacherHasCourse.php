<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TeacherHasCourse
 * 
 * @property int $id
 * @property int $fk_id_course
 * @property int $fk_id_teacher
 * 
 * @property Course $course
 * @property Teacher $teacher
 *
 * @package App\Models
 */
class TeacherHasCourse extends Model
{
	protected $table = 'teacher_has_courses';
	public $timestamps = false;

	protected $casts = [
		'fk_id_course' => 'int',
		'fk_id_teacher' => 'int'
	];

	protected $fillable = [
		'fk_id_course',
		'fk_id_teacher'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'fk_id_course');
	}

	public function teacher()
	{
		return $this->belongsTo(Teacher::class, 'fk_id_teacher');
	}
}
