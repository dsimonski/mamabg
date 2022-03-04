<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Children;
use App\Models\Pregnancy;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::WithChildsAndPregnancy()
            ->latest()
            ->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $user = new User();

        $user->name = $request->input('name');
        $user->save();

        $request->session()->flash('status', 'Потребителят беше създаден!');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $userChildren = Children::WithDates()
            ->where('user_id', $id)
            ->orderByDesc('birthday')
            ->get();

        $userPregnancy = Pregnancy::ActivePregnancy()
            ->with('pregnancyChildren')
            ->where('user_id', $id)
            ->first();

        return view('users.show', [
            'user' => $user,
            'userChildren' => $userChildren,
            'userPregnancy' => $userPregnancy,
            'pregnancyChildrenGenders' => config(
                'mamabg.pregnancyChildrenGenders'
            ),
            'childrenGenders' => config('mamabg.childrenGenders'),
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
        $user = User::findOrFail($id);

        return view('users.edit', ['user' => $user]);
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
        $user = User::findOrFail($id);

        $validator = $this->validateData($request);

        $user->name = $request->input('name');

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'err' => $validator->errors(),
            ]);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'updateData' => [
                'html' => $user->name,
                'type' => 'class',
                'element' => 'userName',
            ],
            'html' => 'Потребителя е редактиран успешно!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        session()->flash('status', 'Потребителя е изтрит успешно!');

        return redirect()->route('users.index');
    }

    private function validateData(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->validationRules(),
            $this->validationMessages()
        );

        return $validator;
    }

    private function validationRules()
    {
        return [
            'name' => 'required|min:3|max:200',
        ];
    }

    private function validationMessages()
    {
        return [
            'name.required' => 'Името е задължително',
            'name.min' => 'Името трябва да е минимално :min синвола',
            'name.max' => 'Името трябва да е максимално :max синвола',
        ];
    }
}
