<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unit
 * 
 * @property int $id
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Course[] $courses
 * @property Collection|Material[] $materials
 *
 * @package App\Models
 */
class Unit extends Model
{
	protected $table = 'unit';

	protected $fillable = [
		'title'
	];

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'course_has_unit', 'fk_id_unit', 'fk_id_course')
					->withPivot('id', 'fk_id_exam');
	}

	public function materials()
	{
		return $this->belongsToMany(Material::class, 'unit_has_material', 'fk_id_unit', 'fk_id_material')
					->withPivot('id');
	}
}
