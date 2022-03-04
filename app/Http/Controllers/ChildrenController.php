<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Children;
use App\Models\User;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $userChildren = Children::where('user_id', $userId)
            ->orderByDesc('birthday')
            ->get();

        return view('children.index', ['userChildren' => $userChildren]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function create($userId)
    {
        $user = User::findOrFail($userId);

        return view('children.create', [
            'user' => $user,
            'genders' => config('mamabg.childrenGenders'),
        ]);

        return view('children.create');
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

        $children = new Children();

        $validator = $this->validateData($request);

        $children->user_id = $user->id;
        $children->name = $request->input('name');
        $children->birthday = $request->input('birthday');
        $children->gender = $request->input('gender');

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'err' => $validator->errors(),
            ]);
        }

        $children->save();

        $userChildren = Children::WithDates()
            ->where('user_id', $children->user_id)
            ->orderByDesc('birthday')
            ->get();

        return response()->json([
            'success' => true,
            'updateData' => [
                'html' => $this->getListingHtml($userChildren),
                'type' => 'id',
                'element' => 'userChildren',
            ],
            'html' => 'Детето е добавено успешно!',
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
        $children = Children::findOrFail($id);

        return view('children.edit', [
            'children' => $children,
            'genders' => config('mamabg.childrenGenders'),
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
        $children = Children::findOrFail($id);

        $validator = $this->validateData($request);

        $children->name = $request->input('name');
        $children->birthday = $request->input('birthday');
        $children->gender = $request->input('gender');

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'err' => $validator->errors(),
            ]);
        }

        $children->save();

        $userChildren = Children::WithDates()
            ->where('user_id', $children->user_id)
            ->orderByDesc('birthday')
            ->get();

        return response()->json([
            'success' => true,
            'updateData' => [
                'html' => $this->getListingHtml($userChildren),
                'type' => 'id',
                'element' => 'userChildren',
            ],
            'html' => 'Детето е редактирано успешно!',
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
        $children = Children::findOrFail($childrenId);

        $children->delete();

        session()->flash('status', 'Детето е изтрит успешно!');

        return redirect()->route('users.show', ['user' => $userId]);
    }

    private function getListingHtml($userChildren)
    {
        return view('children.index', [
            'userChildren' => $userChildren,
            'childrenGenders' => config('mamabg.childrenGenders'),
        ])->render();
    }

    private function validateData(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3|max:200',
                'birthday' =>
                    'required|date_format:Y-m-d|before:today|after:-100year',
                'gender' =>
                    'in:' .
                    implode(',', array_keys(config('mamabg.childrenGenders'))),
            ],
            [
                'name.required' => 'Името е задължително',
                'name.min' => 'Името трябва да е минимално :min синвола',
                'name.max' => 'Името трябва да е максимално :max синвола',
                'birthday.required' => 'Рожденната дата е задължителна',
                'birthday.before' =>
                    'Рожденната дата не може да е след днешната дата',
                'birthday.after' =>
                    'Рожденната дата не може да е преди повече от 100 години',
                'gender.in' => 'Полето пол е невалидно',
            ]
        );
        return $validator;
    }
}
