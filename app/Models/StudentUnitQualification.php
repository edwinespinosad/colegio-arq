<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentUnitQualification
 * 
 * @property int $id
 * @property int $qualification
 *
 * @package App\Models
 */
class StudentUnitQualification extends Model
{
	protected $table = 'student_unit_qualification';
	public $timestamps = false;

	protected $casts = [
		'qualification' => 'int'
	];

	protected $fillable = [
		'qualification'
	];
}
