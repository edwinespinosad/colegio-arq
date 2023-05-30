<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Material
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Unit[] $units
 *
 * @package App\Models
 */
class Material extends Model
{
    protected $table = 'material';

    protected $fillable = [
        'title',
        'link'
    ];

    protected $appends = [
        'icon'
    ];

    public function getIconAttribute()
    {
        return pathinfo($this->link, PATHINFO_EXTENSION);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_has_material', 'fk_id_material', 'fk_id_unit')
            ->withPivot('id');
    }
}
