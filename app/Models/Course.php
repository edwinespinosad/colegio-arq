<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @property int $id
 * @property string $name
 * @property string $duration
 * @property string $description
 * @property string|null $requirements
 * @property string $image
 * @property float $price
 * @property string $type
 * @property Carbon $date_ini
 * @property Carbon $date_fin
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $link_meet
 *
 * @property Collection|Activity[] $activities
 * @property Collection|Exam[] $exams
 * @property Collection|Notice[] $notices
 * @property Collection|Unit[] $units
 * @property Collection|Group[] $groups
 * @property Collection|StudentActivityDelivery[] $student_activity_deliveries
 * @property Collection|Student[] $students
 *
 * @package App\Models
 */
class Course extends Model
{
    protected $table = 'course';

    protected $casts = [
        'price' => 'float',
        'date_ini' => 'datetime',
        'date_fin' => 'datetime',
        'active' => 'bool'
    ];

    protected $fillable = [
        'name',
        'duration',
        'description',
        'requirements',
        'image',
        'price',
        'type',
        'date_ini',
        'date_fin',
        'active',
        'link_meet'
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

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'course_has_activity', 'fk_id_course', 'fk_id_activity')
            ->withPivot('id');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'course_has_exam', 'fk_id_course', 'fk_id_exam')
            ->withPivot('id');
    }

    public function notices()
    {
        return $this->belongsToMany(Notice::class, 'course_has_notices', 'fk_id_course', 'fk_id_notice')
            ->withPivot('id');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'course_has_unit', 'fk_id_course', 'fk_id_unit')
            ->withPivot('id', 'fk_id_exam');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_has_course', 'fk_id_course', 'fk_id_group')
            ->withPivot('id');
    }

    public function student_activity_deliveries()
    {
        return $this->hasMany(StudentActivityDelivery::class, 'fk_id_course');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_has_course', 'fk_id_course', 'fk_id_student')
            ->withPivot('id');
    }
}
