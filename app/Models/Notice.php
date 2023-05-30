<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notice
 * 
 * @property int $id
 * @property string $title
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Course[] $courses
 *
 * @package App\Models
 */
class Notice extends Model
{
	protected $table = 'notice';

	protected $fillable = [
		'title',
		'description'
	];

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'course_has_notices', 'fk_id_notice', 'fk_id_course')
					->withPivot('id');
	}
}
