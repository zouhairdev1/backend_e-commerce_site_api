<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Command;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index()
    {
        $commands = Command::with('lineCommands.product')->get();
        return response()->json($commands);
    }

    public function show($id)
    {
        $command = Command::with('lineCommands.product')->findOrFail($id);
        return response()->json($command);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'status' => 'required|string|max:255',
            'line_commands' => 'required|array',
            'line_commands.*.product_id' => 'required|exists:products,id',
            'line_commands.*.quantity' => 'required|integer|min:1',
            'line_commands.*.price' => 'required|numeric',
        ]);

        $command = Command::create([
            'user_id' => $validated['user_id'],
            'total' => $validated['total'],
            'status' => $validated['status'],
        ]);

        foreach ($validated['line_commands'] as $lineCommand) {
            $command->lineCommands()->create($lineCommand);
        }

        return response()->json($command->load('lineCommands.product'), 201);
    }

    public function update(Request $request, $id)
    {
        $command = Command::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'total' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|string|max:255',
            'line_commands' => 'sometimes|array',
            'line_commands.*.id' => 'sometimes|exists:line_commands,id',
            'line_commands.*.product_id' => 'required_with:line_commands|exists:products,id',
            'line_commands.*.quantity' => 'required_with:line_commands|integer|min:1',
            'line_commands.*.price' => 'required_with:line_commands|numeric',
        ]);

        $command->update($validated);

        if ($request->has('line_commands')) {
            foreach ($validated['line_commands'] as $lineCommandData) {
                if (isset($lineCommandData['id'])) {
                    $lineCommand = $command->lineCommands()->find($lineCommandData['id']);
                    if ($lineCommand) {
                        $lineCommand->update($lineCommandData);
                    }
                } else {
                    $command->lineCommands()->create($lineCommandData);
                }
            }
        }

        return response()->json($command->load('lineCommands.product'));
    }

    public function destroy($id)
    {
        $command = Command::findOrFail($id);
        $command->delete();
        return response()->json(null, 204);
    }
}
