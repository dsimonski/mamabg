<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pregnancy extends Model
{
    use HasFactory;

    protected $table = 'pregnancies';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function pregnancyChildren()
    {
        return $this->hasMany('App\Models\PregnancyChildren');
    }

    public function scopeActivePregnancy(Builder $query)
    {
        return $query
            ->select(
                '*',
                \DB::raw(
                    'DATEDIFF(pregnancies.expected_date, now() ) as pregnancy_expected_remianing_days'
                )
            )
            ->whereRaw('expected_date > NOW()');
    }

    public function scopeByMonth(Builder $query)
    {
        return $query
            ->select(
                \DB::raw("DATE_FORMAT(expected_date, '%c') as month_number"),
                \DB::raw('count(*) as pregnancies_count'),
                \DB::raw(
                    "DATE_FORMAT(expected_date, '%Y-%m') as year_with_month"
                )
            )
            ->whereRaw('expected_date > NOW()')
            ->whereRaw('expected_date < NOW() + INTERVAL 9 MONTH')
            ->groupBy(\DB::raw("DATE_FORMAT(expected_date, '%Y-%m')"));
    }
}
