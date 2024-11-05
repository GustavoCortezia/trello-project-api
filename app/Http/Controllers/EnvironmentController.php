<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EnvironmentController extends Controller
{
    public function index()
    {
        $envir = Environment::all();

        return response()->json(['success' => 'true', 'message' => 'Showing all environments', 'data' => $envir],200);
    }

    public function store(Request $request)
    {
      try {
        $user = Auth::user();

        $request->validate(
            [
                'name' => 'required|string',
            ],
            [
                'required' => ':attribute is required!',
                'string' => ':attribute must be a string!',
            ]
        );

        $envir = Environment::create([
            "name" => $request->name,
            "userId" => $user->id,
        ]);

        return response()->json(['success' => 'true', 'message' => 'Environment created successfully!', 'data' => $envir],201);

    } catch (\Throwable $th) {
        return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
      }
    }

    public function show(string $id)
    {
        try {

            $envir = Environment::findOrFail($id);
            return response()->json(['success' => 'true', 'message' => 'Showing environment successfully', 'data' => $envir],200);

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
                ],
                [
                    'required' => ':attribute is required!',
                    'string' => ':attribute must be a string!',
                ]
            );

            $envir = Environment::findOrFail($id);

            $envir->fill([
                'name' => $request->name,
                'color' => $request->color,
            ]);

            $envir->save();

            return response()->json(['success' => 'true', 'message' => 'Environment updated successfully', 'data' => $envir],200);

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
            $envir = Environment::findOrFail($id);

            $envir->delete();
            return response()->json(['success' => 'true', 'message' => 'Environment deleted successfully', 'data' => $envir],200);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
        }
    }
}
