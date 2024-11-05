<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $section = Section::all();

        return response()->json(['success' => 'true', 'message' => 'Showing all Sections', 'data' => $section],200);
    }

    public function store(Request $request)
    {
      try {
        $request->validate(
            [
                'name' => 'required|string',
                'environmentId' => 'required',
            ],
            [
                'required' => ':attribute is required!',
                'string' => ':attribute must be a string!',
            ]
        );

        $section = Section::create([
            "name" => $request->name,
            "environmentId" => $request->environmentId,
        ]);

        return response()->json(['success' => 'true', 'message' => 'Section created successfully!', 'data' => $section],201);

    } catch (\Throwable $th) {
        return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
      }
    }

    public function show(string $id)
    {
        try {

            $section = Section::findOrFail($id);
            return response()->json(['success' => 'true', 'message' => 'Showing Section successfully', 'data' => $section],200);

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

            $section = Section::findOrFail($id);

            $section->fill([
                'name' => $request->name,
                'color' => $request->color,
            ]);

            $section->save();

            return response()->json(['success' => 'true', 'message' => 'Section updated successfully', 'data' => $section],200);

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
            $section = Section::findOrFail($id);

            $section->delete();
            return response()->json(['success' => 'true', 'message' => 'Section deleted successfully', 'data' => $section],200);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
        }
    }
}
