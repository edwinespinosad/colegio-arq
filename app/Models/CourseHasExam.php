<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseHasExam
 * 
 * @property int $id
 * @property int $fk_id_course
 * @property int $fk_id_exam
 * 
 * @property Course $course
 * @property Exam $exam
 *
 * @package App\Models
 */
class CourseHasExam extends Model
{
	protected $table = 'course_has_exam';
	public $timestamps = false;

	protected $casts = [
		'fk_id_course' => 'int',
		'fk_id_exam' => 'int'
	];

	protected $fillable = [
		'fk_id_course',
		'fk_id_exam'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'fk_id_course');
	}

	public function exam()
	{
		return $this->belongsTo(Exam::class, 'fk_id_exam');
	}
}
