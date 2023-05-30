<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseHasActivity
 * 
 * @property int $id
 * @property int $fk_id_course
 * @property int $fk_id_activity
 * 
 * @property Activity $activity
 * @property Course $course
 *
 * @package App\Models
 */
class CourseHasActivity extends Model
{
	protected $table = 'course_has_activity';
	public $timestamps = false;

	protected $casts = [
		'fk_id_course' => 'int',
		'fk_id_activity' => 'int'
	];

	protected $fillable = [
		'fk_id_course',
		'fk_id_activity'
	];

	public function activity()
	{
		return $this->belongsTo(Activity::class, 'fk_id_activity');
	}

	public function course()
	{
		return $this->belongsTo(Course::class, 'fk_id_course');
	}
}
