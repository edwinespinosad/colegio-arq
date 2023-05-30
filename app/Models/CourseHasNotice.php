<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseHasNotice
 * 
 * @property int $id
 * @property int $fk_id_course
 * @property int $fk_id_notice
 * 
 * @property Course $course
 * @property Notice $notice
 *
 * @package App\Models
 */
class CourseHasNotice extends Model
{
	protected $table = 'course_has_notices';
	public $timestamps = false;

	protected $casts = [
		'fk_id_course' => 'int',
		'fk_id_notice' => 'int'
	];

	protected $fillable = [
		'fk_id_course',
		'fk_id_notice'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'fk_id_course');
	}

	public function notice()
	{
		return $this->belongsTo(Notice::class, 'fk_id_notice');
	}
}
