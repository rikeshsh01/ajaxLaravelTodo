<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ListController extends Controller
{
    public function index()
    {
        $list=Todo::all();
        return view('list',compact('list'));
    }
    public function create(Request $request)
    {
        $todo['todo'] =$request->text ;
        $todos=Todo::create($todo);
        return Response::json($todos);
    }

    public function delete(Request $request)
    {
        $id=$request->id;
        $data=Todo::findOrFail($id);
        $data->delete();
        return Response::json($data);

    }

    public function update(Request $request)
    {
        $todo = Todo::find($request->id);
        $todo->todo = $request->text;
        $todo->save();
        return Response::json($todo);
    }

    public function search(Request $request){
        $term=$request->term;
        $item=Todo::where('todo','LIKE','%'.$term.'%')->get();
        if (count($item)==0) {
            $searchResults[]='No item found';
        }
        else
        {
            foreach($item as $value)
            {
                $searchResults[]=$value->todo;
            }
        }
        return $searchResults;
    }
}
