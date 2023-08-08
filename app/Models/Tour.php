<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'travel_id',
        'name',
        'starting_date',
        'ending_date',
        'price'
    ];


    protected $appends = ['number_of_nights'];


    /**
     * Get the travel that owns the tour.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }


    /**
     * compute number of nights in tour
     * @return mixed
     */
    public function getNumberOfNightsAttribute()
    {
        $starting_date = new \DateTime($this->starting_date);
        $ending_date = new \DateTime($this->ending_date);
        $interval = $starting_date->diff($ending_date);

        return $interval->days;
    }


    /**
     * Get tour price using specific format
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
        );
    }
}
