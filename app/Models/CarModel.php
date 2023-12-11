<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarModel extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'car_company_id'];

    protected $searchableFields = ['*'];

    protected $table = 'car_models';

    public function carCompany()
    {
        return $this->belongsTo(CarCompany::class);
    }

    public function carVersions()
    {
        return $this->hasMany(CarVersion::class);
    }
}
