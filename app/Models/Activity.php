<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * 
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $help_material
 * @property Carbon $limit_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Course[] $courses
 *
 * @package App\Models
 */
class Activity extends Model
{
	protected $table = 'activity';

	protected $casts = [
		'limit_date' => 'datetime'
	];

	protected $fillable = [
		'title',
		'description',
		'help_material',
		'limit_date'
	];

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'course_has_activity', 'fk_id_activity', 'fk_id_course')
					->withPivot('id');
	}
}
