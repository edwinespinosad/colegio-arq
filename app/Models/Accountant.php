<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Accountant
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
 * @package App\Models
 */
class Accountant extends Model
{
	protected $table = 'accountant';

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
}
