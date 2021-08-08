<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Validator;
class TodoController extends Controller
{
    //
    public function __invoke()
    {
        return Todo::all();
    }

    public function index()
    {
        return Todo::all();
    }

    public function show($id)
    {
        return Todo::find($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $data = ['errors' => $validator->errors()];
            return response($data)->setStatusCode(422);

        }

        return Todo::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $data = ['errors' => $validator->errors()];
            return response($data)->setStatusCode(422);
        }
        $todo->update($request->all());
        return $todo;
    }

    public function delete(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return ['success'=> true];
    }

    private function validator($data)
    {
        return Validator::make((array)$data, [
            'task' => 'required|min:10',
            'user_id' => 'required|integer',
            'done' => 'required|boolean',
        ]);
    }
}
