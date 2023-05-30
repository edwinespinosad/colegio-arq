<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Exam
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $link
 * @property Carbon $date_ini
 * @property Carbon $date_fin
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Course[] $courses
 * @property Collection|CourseHasUnit[] $course_has_units
 *
 * @package App\Models
 */
class Exam extends Model
{
	protected $table = 'exam';

	protected $casts = [
		'date_ini' => 'datetime',
		'date_fin' => 'datetime',
		'active' => 'bool'
	];

	protected $fillable = [
		'name',
		'description',
		'link',
		'date_ini',
		'date_fin',
		'active'
	];

    protected $appends = ['format_date_ini', 'format_date_fin'];

    public function getFormatDateIniAttribute()
    {
        return $this->attributes['date_ini'] ? date('d-m-Y', strtotime($this->attributes['date_ini'])) : null;
    }

    public function getFormatDateFinAttribute()
    {
        return $this->attributes['date_fin'] ? date('d-m-Y', strtotime($this->attributes['date_fin'])) : null;
    }

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'course_has_exam', 'fk_id_exam', 'fk_id_course')
					->withPivot('id');
	}

	public function course_has_units()
	{
		return $this->hasMany(CourseHasUnit::class, 'fk_id_exam');
	}
}
