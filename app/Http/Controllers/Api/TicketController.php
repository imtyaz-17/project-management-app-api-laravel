<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    public function store(TicketCreateRequest $request)
    {
        $data = $request->validated();
        $ticket = Ticket::create([
            ...$data,
            'creator_id'=>$request->user()->id,
        ]);

        return new TicketResource($ticket);
    }
    public function show(string $ticket)
    {
        $ticket = Ticket::with('creator','members')->findOrFail($ticket);
        return new TicketResource($ticket);
    }
    public function update(TicketCreateRequest $request, Ticket $ticket)
    {
        $data = $request->validated();
        $ticket->update($data);
        return new TicketResource($ticket);
    }
    public function destroy(Request $request,Ticket $ticket)
    {
        $ticket->delete();
        return response()->json([
            'message' => 'Ticket deleted successfully'
        ]);
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'users' => ['required', 'array'],
        ]);

        $users = User::whereIn('email', $data['users'])->select('id', 'email')->get();
        $ticket->members()->sync($users->pluck('id'));

        return new TicketResource($ticket);
    }
}
