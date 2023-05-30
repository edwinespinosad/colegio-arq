<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentHasCourse
 * 
 * @property int $id
 * @property int $fk_id_student
 * @property int $fk_id_course
 * 
 * @property Course $course
 * @property Student $student
 *
 * @package App\Models
 */
class StudentHasCourse extends Model
{
	protected $table = 'student_has_course';
	public $timestamps = false;

	protected $casts = [
		'fk_id_student' => 'int',
		'fk_id_course' => 'int'
	];

	protected $fillable = [
		'fk_id_student',
		'fk_id_course'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'fk_id_course');
	}

	public function student()
	{
		return $this->belongsTo(Student::class, 'fk_id_student');
	}
}
