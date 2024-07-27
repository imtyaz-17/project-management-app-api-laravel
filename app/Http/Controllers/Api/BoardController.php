<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardCreateRequest;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    //
    public function store(BoardCreateRequest $request)
    {
        $data = $request->validated();
        $board = Board::create($data);

        return new BoardResource($board);
    }
    public function update(BoardCreateRequest $request, Board $board)
    {
        $data = $request->validated();
        $board->update($data);
        return new BoardResource($board);
    }
    public function destroy(Request $request, Board $board)
    {
        $board->load('projects');
        abort_if($board->project->user_id !== $request->user()->id, 403, "You are not allowed to delete this project");
        $board->delete();
        return response()->json([
            'message' => 'Board deleted successfully'
        ]);
    }

}
