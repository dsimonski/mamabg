<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Pregnancy;
use App\Models\PregnancyChildren;
use App\Models\User;

class PregnancyController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function create($userId)
    {
        $user = User::findOrFail($userId);

        return view('pregnancy.create', [
            'user' => $user,
            'genders' => config('mamabg.pregnancyChildrenGenders'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        if (
            Pregnancy::ActivePregnancy()
                ->where('user_id', $userId)
                ->count() > 0
        ) {
            return response()->json([
                'success' => true,
                'html' => 'Може да имате само една бременност!',
            ]);
        }

        $pregnancy = new Pregnancy();

        $validator = $this->validateData($request);

        $pregnancy->user_id = $user->id;
        $pregnancy->expected_date = $request->input('expected_date');

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'err' => $validator->errors(),
            ]);
        }

        $pregnancy->save();

        PregnancyChildren::where('pregnancy_id', $pregnancy->id)->delete();

        foreach ($request->input('gender') as $childGender) {
            $pregnancyChildren = new PregnancyChildren();
            $pregnancyChildren->pregnancy_id = $pregnancy->id;
            $pregnancyChildren->gender = $childGender;
            $pregnancyChildren->save();
        }

        $userPregnancy = Pregnancy::ActivePregnancy()
            ->with('pregnancyChildren')
            ->where('user_id', $pregnancy->user_id)
            ->first();

        return response()->json([
            'success' => true,
            'updateData' => [
                'html' => $this->getListingHtml($userPregnancy),
                'type' => 'id',
                'element' => 'userPregnancy',
            ],
            'deleteElement' => [
                'type' => 'id',
                'element' => 'addPregnancy',
            ],
            'html' => 'Бременността е добавена успешно!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userPregnancy = Pregnancy::ActivePregnancy()
            ->with('pregnancyChildren')
            ->findOrFail($id);

        $pregnancyChildrenArr = [];
        foreach ($userPregnancy->pregnancyChildren->toArray() as $val) {
            $pregnancyChildrenArr[] = $val['gender'];
        }

        return view('pregnancy.edit', [
            'pregnancy' => $userPregnancy,
            'pregnancyChildren' => $pregnancyChildrenArr,
            'genders' => config('mamabg.pregnancyChildrenGenders'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pregnancy = Pregnancy::findOrFail($id);

        $validator = $this->validateData($request);

        $pregnancy->expected_date = $request->input('expected_date');

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'err' => $validator->errors(),
            ]);
        }

        $pregnancy->save();

        PregnancyChildren::where('pregnancy_id', $pregnancy->id)->delete();

        foreach ($request->input('gender') as $childGender) {
            $pregnancyChildren = new PregnancyChildren();
            $pregnancyChildren->pregnancy_id = $pregnancy->id;
            $pregnancyChildren->gender = $childGender;
            $pregnancyChildren->save();
        }

        $userPregnancy = Pregnancy::ActivePregnancy()
            ->with('pregnancyChildren')
            ->where('user_id', $pregnancy->user_id)
            ->first();

        return response()->json([
            'success' => true,
            'updateData' => [
                'html' => $this->getListingHtml($userPregnancy),
                'type' => 'id',
                'element' => 'userPregnancy',
            ],
            'html' => 'Бременността е редактирана успешно!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $childrenId)
    {
        $userPregnancy = Pregnancy::findOrFail($childrenId);
        PregnancyChildren::where('pregnancy_id', $userPregnancy->id)->delete();
        $userPregnancy->delete();

        session()->flash(
            'status',
            'Данните за бременността са изтрит успешно!'
        );

        return redirect()->route('users.show', ['user' => $userId]);
    }

    private function getListingHtml($userPregnancy)
    {
        return view('pregnancy.index', [
            'userPregnancy' => $userPregnancy,
            'pregnancyChildrenGenders' => config(
                'mamabg.pregnancyChildrenGenders'
            ),
        ])->render();
    }

    private function validateData(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'expected_date' =>
                    'required|date_format:Y-m-d|before:+40 week|after:today',
                'gender.*' =>
                    'in:' .
                    implode(
                        ',',
                        array_keys(config('mamabg.pregnancyChildrenGenders'))
                    ),
            ],
            [
                'expected_date.required' => 'Дата на термина е задължителна',
                'expected_date.before' =>
                    'Термина не може да е след повече от 40 седмици',
                'expected_date.after' => 'Термина не може да е преди днес',
                'gender.in' => 'Полето пол е невалидно',
            ]
        );
        return $validator;
    }
}
