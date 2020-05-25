<?php

namespace App\Http\Controllers;

use App\RoomParticipants;
use Illuminate\Http\Request;

class RoomParticipantsController extends BaseController
{
    public function index()
    {
//        $roomParticipants = RoomParticipants::all();
//        $roomParticipants = DB::table("room_participants")
//            ->join('rooms', 'room_participants.room_id', '=', 'rooms.id')
//            ->join('members', 'room_participants.member_id', '=', 'members.id')
//            ->select('room_participants.*', 'rooms.*', 'members.*')
//            ->get();

        $roomParticipants = RoomParticipants::with(['room', 'member'])->get();

        return $this->sendResponse($roomParticipants, 'Data retrieved successfully');
    }

    public function show($id)
    {
        $roomParticipants = RoomParticipants::find($id)::with(['room', 'member'])->first();
        return $this->sendResponse($roomParticipants, 'Data retrieved successfully');
    }

    public function store(Request $request)
    {
        $roomParticipants = RoomParticipants::create($request->all());
        return $this->sendResponse($roomParticipants, 'Data added sucessfully');
    }

    public function update(Request $request, $id)
    {
        $roomParticipant = RoomParticipants::findorFail($id);
        $roomParticipant->update($request->all());
        return $this->sendResponse($roomParticipant, 'Data updated successfully');
    }


    public function delete(Request $request, $id)
    {
        try {
            $roomParticipant = RoomParticipants::findorFail($id);
            $roomParticipant->delete();

            return $this->sendResponse('', 'Data deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

}