<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarOption extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'description', 'price', 'car_version_id'];

    protected $searchableFields = ['*'];

    protected $table = 'car_options';

    public function carVersion()
    {
        return $this->belongsTo(CarVersion::class);
    }
}
