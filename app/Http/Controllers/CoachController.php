<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CoachController extends Controller
{
    public function addCoach(Request $request){

        $data = $request->validate([
            'user_id' => '',
            'firstName' => '',
            'lastName' => '',
            'description' => '',
            'email' => '',
            'age' => '',
            'phone' => '',
            'image' => ''
        ]);

        $data['user_id'] = auth()->id();

        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        DB::table('coaches')->insert($data);
        return response()->json(['message' => 'Uspjesno dodan trener'], 201);
    }

    public function getCoaches(){
        $coaches = Coach::get();
        return response()->json(['coaches' => $coaches]);
    }

    public function deleteCoach($id){
        $coach = Coach::findorFail($id);
        $coach->delete();
        return response()->json(['message' => 'Trener izbrisan']);
    }

    public function updateCoach(Request $request, $id){

        $coach = Coach::findOrFail($id);
        $data = $request->validate([
            'firstName' => '',
            'lastName' => '',
            'description' => '',
            'email' => '',
            'age' => '',
            'phone' => '',
            'image' => '',

        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }


        DB::table('coaches')
    ->where('id', $id)
    ->update([
        'firstName' => $data['firstName'],
        'lastName' => $data['lastName'],
        'email' => $data['email'],
        'age' => $data['age'],
        'phone' => $data['phone'],
        'description' => $data['description'],
        'image' => $data['image']
    ]);

        $coach->save();
        return response()->json([
            'poruka' => 'Uspjesno uredjeno',
            'coach' => $coach,
        ]);
    }

    public function searchCoach(Request $request){
        $searchText = $request->input('searchText');
        $results = Coach::where('firstName', 'like', "%$searchText%")->get();
        return response()->json(['results' => $results]);
    }
}
