<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;

/**
 * Class Student
 *
 * @property int $id
 * @property string $name
 * @property string $middle_name
 * @property string $last_name
 * @property int|null $age
 * @property string|null $phone
 * @property string $email
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Course[] $courses
 * @property Collection|Group[] $groups
 *
 * @package App\Models
 */
class Student extends Authenticable
{
	protected $table = 'student';

	protected $casts = [
		'age' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'middle_name',
		'last_name',
		'age',
		'phone',
		'email',
		'password'
	];

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'student_has_course', 'fk_id_student', 'fk_id_course')
					->withPivot('id');
	}

	public function groups()
	{
		return $this->belongsToMany(Group::class, 'student_has_group', 'fk_id_student', 'fk_id_group')
					->withPivot('id');
	}
}
