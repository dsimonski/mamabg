<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Children;
use App\Models\Pregnancy;

class HomeController extends Controller
{
    public const MONTHS = [
        1 => 'Януари',
        2 => 'Февруари',
        3 => 'Март',
        4 => 'Април',
        5 => 'Май',
        6 => 'Юни',
        7 => 'Юли',
        8 => 'Август',
        9 => 'Септември',
        10 => 'Октомври',
        11 => 'Ноември',
        12 => 'Декември',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::count();
        $children = Children::count();
        $pregnancies = Pregnancy::ActivePregnancy()->count();

        $averageChildByUser = 0;
        if ($users) {
            $averageChildByUser = round($children / $users, 2);
        }

        $childrenByAge = Children::ByAge()->first();

        $pregnanciesByMonth = Pregnancy::ByMonth()->get();

        $currentMonth = $month = idate('m');

        $pregnanciesByMonthData = [];

        for ($i = 0; $i < 9; $i++) {
            $monthKey = $currentMonth + $i;

            if ($monthKey > 12) {
                $monthKey -= 12;
            }
            $pregnanciesByMonthData[$monthKey]['month_name'] =
                self::MONTHS[$monthKey];
            $pregnanciesByMonthData[$monthKey]['pregnancies_count'] = 0;
        }

        foreach ($pregnanciesByMonth as $pregnanciesCount) {
            if (
                isset($pregnanciesByMonthData[$pregnanciesCount->month_number])
            ) {
                $pregnanciesByMonthData[$pregnanciesCount->month_number][
                    'pregnancies_count'
                ] = $pregnanciesCount->pregnancies_count;
            }
        }

        return view('home.index', [
            'users' => $users,
            'children' => $children,
            'pregnancies' => $pregnancies,
            'averageChildByUser' => $averageChildByUser,
            'childrenByAge' => $childrenByAge,
            'pregnanciesByMonthData' => $pregnanciesByMonthData,
        ]);
    }
}
