<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Course[] $courses
 * @property Collection|Student[] $students
 * @property Collection|Teacher[] $teachers
 *
 * @package App\Models
 */
class Group extends Model
{
	protected $table = 'group';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'group_has_course', 'fk_id_group', 'fk_id_course')
					->withPivot('id');
	}

	public function students()
	{
		return $this->belongsToMany(Student::class, 'student_has_group', 'fk_id_group', 'fk_id_student')
					->withPivot('id');
	}

	public function teachers()
	{
		return $this->belongsToMany(Teacher::class, 'teacher_has_group', 'fk_id_group', 'fk_id_teacher')
					->withPivot('id');
	}
}
