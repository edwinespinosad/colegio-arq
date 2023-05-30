<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentActivityDelivery
 * 
 * @property int $id
 * @property int $fk_id_student
 * @property int $fk_id_course_has_activity
 * @property string|null $link
 * @property float|null $qualification
 * @property bool $delivered
 * 
 * @property CourseHasActivity $course_has_activity
 * @property Student $student
 *
 * @package App\Models
 */
class StudentActivityDelivery extends Model
{
	protected $table = 'student_activity_delivery';
	public $timestamps = false;

	protected $casts = [
		'fk_id_student' => 'int',
		'fk_id_course_has_activity' => 'int',
		'qualification' => 'float',
		'delivered' => 'bool'
	];

	protected $fillable = [
		'fk_id_student',
		'fk_id_course_has_activity',
		'link',
		'qualification',
		'delivered'
	];

	public function course_has_activity()
	{
		return $this->belongsTo(CourseHasActivity::class, 'fk_id_course_has_activity');
	}

	public function student()
	{
		return $this->belongsTo(Student::class, 'fk_id_student');
	}
}
