<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarVersion extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['car_model_id', 'year', 'initial_price', 'photo'];

    protected $searchableFields = ['*'];

    protected $table = 'car_versions';

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function carOptions()
    {
        return $this->hasMany(CarOption::class);
    }
}
