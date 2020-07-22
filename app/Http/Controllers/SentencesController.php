<?php

namespace App\Http\Controllers;

use App\Models\Entity\Book;
use App\Models\Entity\Sentence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SentencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Sentence $sentence, Book $book, Request $request)
    {
        $user = auth()->user();
        $data = $request->id;
        $book->id = $data;


        return view('sentences.create',[
            'user' => $user,
            'book' => $book,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Book $book, Sentence $sentence)
    {
        $user = auth()->user();
        $data = $request->all();

        $validator = Validator::make($data, [
            'book_id' => ['required', 'integer'],
            'text' => ['required', 'string', 'max:2000']
        ]);

        $validator->validate();
        $sentence->sentenceStore($user->id, $data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
