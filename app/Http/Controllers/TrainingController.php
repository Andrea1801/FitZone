<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function addTraining(Request $request){

        $data = $request->validate([
            'user_id' => '',
            'name' => '',
            'description' => '',
            'price' => '',
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

        DB::table('trainings')->insert($data);
        return response()->json(['message' => 'Uspjesno dodan trening'], 201);
    }
    public function getTrainings(){
        $trainings = Training::get();
        return response()->json(['trainings' => $trainings]);
    }

    public function deleteTraining($id){
        $training = Training::findorFail($id);
        $training->delete();
        return response()->json(['message' => 'Trening izbrisan']);
    }

    public function searchTraining(Request $request){
        $searchText = $request->input('searchText');
        $results = Training::where('name', 'like', "%$searchText%")->get();
        return response()->json(['results' => $results]);
    }
}
