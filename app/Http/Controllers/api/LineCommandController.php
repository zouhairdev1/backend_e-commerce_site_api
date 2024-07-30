<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Line_commands;
use Illuminate\Http\Request;

class LineCommandController extends Controller
{
    public function index()
    {
        $lineCommands = Line_commands::with(['command', 'product'])->get();
        return response()->json($lineCommands);
    }

    public function show($id)
    {
        $lineCommand = Line_commands::with(['command', 'product'])->findOrFail($id);
        return response()->json($lineCommand);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'command_id' => 'required|exists:commands,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $lineCommand = Line_commands::create($validated);
        return response()->json($lineCommand->load(['command', 'product']), 201);
    }

    public function update(Request $request, $id)
    {
        $lineCommand = Line_commands::findOrFail($id);

        $validated = $request->validate([
            'command_id' => 'sometimes|required|exists:commands,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric',
        ]);

        $lineCommand->update($validated);
        return response()->json($lineCommand->load(['command', 'product']));
    }

    public function destroy($id)
    {
        $lineCommand = Line_commands::findOrFail($id);
        $lineCommand->delete();
        return response()->json(null, 204);
    }
}
