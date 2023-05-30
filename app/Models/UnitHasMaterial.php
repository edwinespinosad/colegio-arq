<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UnitHasMaterial
 * 
 * @property int $id
 * @property int $fk_id_material
 * @property int|null $fk_id_unit
 * @property int $fk_id_course_has_unit
 * 
 * @property CourseHasUnit $course_has_unit
 * @property Material $material
 * @property Unit|null $unit
 *
 * @package App\Models
 */
class UnitHasMaterial extends Model
{
	protected $table = 'unit_has_material';
	public $timestamps = false;

	protected $casts = [
		'fk_id_material' => 'int',
		'fk_id_unit' => 'int',
		'fk_id_course_has_unit' => 'int'
	];

	protected $fillable = [
		'fk_id_material',
		'fk_id_unit',
		'fk_id_course_has_unit'
	];

	public function course_has_unit()
	{
		return $this->belongsTo(CourseHasUnit::class, 'fk_id_course_has_unit');
	}

	public function material()
	{
		return $this->belongsTo(Material::class, 'fk_id_material');
	}

	public function unit()
	{
		return $this->belongsTo(Unit::class, 'fk_id_unit');
	}
}
