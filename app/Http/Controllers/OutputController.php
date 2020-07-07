<?php

namespace App\Http\Controllers;

use App\Output;
use Dotenv\Validator;
use Illuminate\Http\Request;

class OutputController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request,Output $output)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data,[
            'book_id' => ['required', 'integer'],
            'text' => ['required', 'string', 'max:140']
        ]);

        $validator->validate();
        $output->outputStore($user->id, $data);

        return back();
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
