<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function children()
    {
        return $this->hasMany('App\Models\Children');
    }

    public function pregnancy()
    {
        return $this->hasOne('App\Models\Children');
    }

    public function scopeWithChildsAndPregnancy(Builder $query)
    {
        return $query
            ->select(
                'users.*',
                \DB::raw('count(DISTINCT children.id) as count_childs'),
                \DB::raw('count(DISTINCT pregnancies.id) as count_pregnancy'),
                \DB::raw(
                    'pregnancies.expected_date AS pregnancy_expected_date'
                ),
                \DB::raw(
                    'DATEDIFF(pregnancies.expected_date, now() ) as pregnancy_expected_remianing_days'
                )
            )
            ->leftJoin('children', 'users.id', '=', 'children.user_id')
            ->leftJoin('pregnancies', function ($join) {
                $join
                    ->on('users.id', '=', 'pregnancies.user_id')
                    ->whereRaw('pregnancies.expected_date > NOW()');
            })
            ->groupBy('users.id');
    }
}
