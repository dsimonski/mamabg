<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Children extends Model
{
    use HasFactory;

    protected $table = 'children';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeWithDates(Builder $query)
    {
        return $query->select(
            '*',
            \DB::raw('DATEDIFF(now(), birthday) as user_days'),
            \DB::raw(
                "period_diff(date_format(now(), '%Y%m'), date_format(birthday, '%Y%m')) - if(date_format(now(), '%c') < date_format(birthday, 'c'), 1, 0) AS user_months"
            )
        );
    }

    public function scopeByAge(Builder $query)
    {
        return $query->select(
            \DB::raw(
                'sum( IF(birthday + INTERVAL 1 year > now(), 1, 0)) AS child_to_1'
            ),
            \DB::raw(
                'sum( IF((birthday + INTERVAL 6 year >= now() AND birthday + INTERVAL 1 year <= now() ), 1, 0)) AS child_1_to_6'
            ),
            \DB::raw(
                'sum( IF((birthday + INTERVAL 18 year >= now() AND birthday + INTERVAL 6 year < now() ), 1, 0)) AS child_7_to_18'
            )
        );
    }
}
