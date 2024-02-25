<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function addMember(Request $request){

        $data = $request -> validate([
            'user_id' => '',
            'firstName' => '',
            'lastName' => '',
            'coach_id' => 'required',
            'training_id' => 'required'
        ],
        );
        $data['user_id'] = auth()->id();

        $existingMember = Member::where('user_id', $data['user_id'])
    ->where('training_id', $data['training_id'])
    ->where('coach_id', $data['coach_id'])
    ->first();

        if($existingMember){
            return response()->json(['message' => 'Member already exists'], 409);
        }



        $member = new Member();
        $member->create($data);
        return response()->json(['message' => 'Učanjivanje uspješno'], 201);
    }

    public function getMember(){
        $members = Member::with('user','coach', 'training')->get();
        return response()->json(['members' => $members]);
    }

    public function deleteMember($id){
        $member = Member::findorFail($id);
        $member->delete();
        return response()->json(['message' => 'Izbrisana članarina']);
    }
}
