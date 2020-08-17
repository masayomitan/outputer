<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Sentence;
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
        //$status_id = 0;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Book $book, Request $request, Sentence $sentence)
    {
        $user = auth()->user();
        $book_id = $request->id;
        $book->id = $book_id;
        $book = $book->getBook($book_id);

        $sentence_status_texts = $sentence->getPostSentenceStatusTexts();

        return view('sentences.create',[
            'sentence_status_texts' => $sentence_status_texts,
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
    public function store(Request $request, Sentence $sentence)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'book_id' => ['required', 'integer'],
            'text_1' => ['required', 'string', 'max:35'],
            'text_2' => ['required', 'string', 'max:35'],
            'text_3' => ['required', 'string', 'max:35']
        ]);
        $validator->validate();
        $sentence->sentenceStore($user->id, $data);
        return redirect()->route('books.show', $sentence['book_id']);
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
    public function edit(Request $request, Book $book, Sentence $sentence)
    {
        $user = auth()->user();

        $book = $sentence->getBookEditSentence($user->id, $sentence->id);
        $sentences = $sentence->getEditSentence($user->id, $sentence->id);

        $sentence_status_texts = $sentence->getPostSentenceStatusTexts();

        return view('sentences.edit', [
            'sentence_status_texts' => $sentence_status_texts,
            'user' => $user,
            'sentences' => $sentences,
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sentence $sentence)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'text_1' => ['required', 'string', 'max:35'],
            'text_2' => ['required', 'string', 'max:35'],
            'text_3' => ['required', 'string', 'max:35']
        ]);
        $validator->validate();
        $sentence->sentenceUpdate($user->id, $data);
        return redirect()->route('books.show', $sentence['book_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sentence $sentence, Request $request)
    {
        $user = auth()->user();
        $sentence->sentenceDestroy($user->id, $sentence->id);
        $redirect = $request->input('redirect');
        if ($redirect == "on") {
            return redirect('/');
          } else {
            return back();
        }
    }
}
