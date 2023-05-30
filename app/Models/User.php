<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;

/**
 * Class User
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
 * @package App\Models
 */
class User extends Authenticable
{
    protected $table = 'user';

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
}
