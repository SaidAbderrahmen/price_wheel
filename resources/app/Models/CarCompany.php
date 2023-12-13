<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarCompany extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'logo'];

    protected $searchableFields = ['*'];

    protected $table = 'car_companies';

    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }
}
