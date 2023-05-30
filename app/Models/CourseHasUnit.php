<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseHasUnit
 * 
 * @property int $id
 * @property int $fk_id_course
 * @property int $fk_id_unit
 * @property int|null $fk_id_exam
 * 
 * @property Course $course
 * @property Exam|null $exam
 * @property Unit $unit
 * @property Collection|UnitHasMaterial[] $unit_has_materials
 *
 * @package App\Models
 */
class CourseHasUnit extends Model
{
	protected $table = 'course_has_unit';
	public $timestamps = false;

	protected $casts = [
		'fk_id_course' => 'int',
		'fk_id_unit' => 'int',
		'fk_id_exam' => 'int'
	];

	protected $fillable = [
		'fk_id_course',
		'fk_id_unit',
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

	public function unit()
	{
		return $this->belongsTo(Unit::class, 'fk_id_unit');
	}

	public function unit_has_materials()
	{
		return $this->hasMany(UnitHasMaterial::class, 'fk_id_course_has_unit');
	}
}
