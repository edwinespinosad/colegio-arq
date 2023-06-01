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
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|StudentActivityDelivery[] $student_activity_deliveries
 * @property Collection|Course[] $courses
 * @property Collection|Group[] $groups
 *
 * @package App\Models
 */
class Student extends Authenticable
{
	protected $table = 'student';

	protected $casts = [
		'age' => 'int',
		'active' => 'bool'
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
		'password',
		'active'
	];

    protected $appends = [
        'full_last_name'
    ];

    public function getFullLastNameAttribute()
    {
        return $this->middle_name . ' ' . $this->last_name;
    }

	public function student_activity_deliveries()
	{
		return $this->hasMany(StudentActivityDelivery::class, 'fk_id_student');
	}

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
