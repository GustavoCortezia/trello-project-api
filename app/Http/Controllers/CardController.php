<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $card = Card::all();

        return response()->json(['success' => 'true', 'message' => 'Showing all Cards', 'data' => $card],200);
    }

    public function store(Request $request)
    {
      try {
        $request->validate(
            [
                'name' => 'required|string',
                'environmentId' => 'required',
                'sectionId' => 'required'
            ],
            [
                'required' => ':attribute is required!',
                'string' => ':attribute must be a string!',
            ]
        );

        $card = Card::create([
            "name" => $request->name,
            "environmentId" => $request->environmentId,
            "sectionId" => $request->sectionId,
        ]);

        return response()->json(['success' => 'true', 'message' => 'Card created successfully!', 'data' => $card],201);

    } catch (\Throwable $th) {
        return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
      }
    }

    public function show(string $id)
    {
        try {

            $card = Card::findOrFail($id);
            return response()->json(['success' => 'true', 'message' => 'Showing Card successfully', 'data' => $card],200);

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

            $card = Card::findOrFail($id);

            $card->fill([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $card->save();

            return response()->json(['success' => 'true', 'message' => 'Card updated successfully', 'data' => $card],200);

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
            $card = Card::findOrFail($id);

            $card->delete();
            return response()->json(['success' => 'true', 'message' => 'Card deleted successfully', 'data' => $card],200);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()]);
        }
    }
}

