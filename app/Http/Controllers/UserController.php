<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return response()->json(['success' => 'true', 'message' => 'Showing all users', 'data' => $users],200);
    }

    public function store(Request $request)
    {
      try {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
            ],
            [
                'required' => ':attribute is required!',
                'string' => ':attribute must be a string!',
                'email' => ':attribute must be valid!',
                'unique' => ':attribute must be unique!'
            ]
        );

        $data = $request->all();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json(['success' => 'true', 'message' => 'User created successfully!', 'data' => $user],201);

    } catch (\Throwable $th) {
        return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
      }
    }

    public function show(string $id)
    {
        try {

            $user = User::findOrFail($id);
            return response()->json(['success' => 'true', 'message' => 'Showing user successfully', 'data' => $user],200);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {

        try {

            $request->validate(
                [
                    'name' => 'required|string',
                    'email' => ['required', 'email',  Rule::unique('users')->ignore($id) ,'email'],
                ],
                [
                    'required' => ':attribute is required!',
                    'string' => ':attribute must be a string!',
                    'email' => ':attribute must be valid!',
                    'unique' => ':attribute must be unique!'
                ]
            );

            $user = User::findOrFail($id);

            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user->save();

            return response()->json(['success' => 'true', 'message' => 'User updated successfully', 'data' => $user],200);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();
            return response()->json(['success' => 'true', 'message' => 'User deleted successfully', 'data' => $user],200);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
        }
    }
}
