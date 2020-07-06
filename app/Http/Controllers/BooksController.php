<?php

namespace App\Http\Controllers;

use App\User;
use Dotenv\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tag;

class BooksController extends Controller
{

    public function fetch(Request $request, Book $book){
        $statusid = 0;

        switch($request["mode"]){
            case "tag";
            //::withでbookの小テーブルの情報も一緒に取り出す
            //https://github.com/laravel/framework/issues/18415, whereHas遅い問題があり改善必要
            $books = Book::with(['tags', 'user', 'favorites'])->whereHas('tags', function(Builder $query) use ($request){
                $query->where('tag_id',$request["tag_id"]);
                //作成順に６データずつ表示
            })->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
        break;

        case "popular":
            $books = $book->getPopularBooks();
            $books = $books->with(['tags', 'user', 'favorites'])->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
        break;

        default:
            $books = Book::with(['tags','user','favorites'])->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
        }
        return $books;
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Book $book, Tag $tags, User $user){

        switch($request["mode"]){
            case "popular":
                $api = "/fetch?mode=popular";
            break;
            default:
                $api = "/fetch";
        }
        $popular_tags = $tags->getPopularTags();
        $popular_users = $user->getPopularUsers();
        $tab_info_list = $book->getTabInfoList();

        return view('books.index', [
            'popular_tags' => $popular_tags,
            'popular_users' => $popular_users,
            'api' => $api,
            'tab_info_list' => $tab_info_list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Book $book){
        $book_status_texts = $book->getPostBookStatusTexts();
        $user = auth()->user();
        return view('books.create',[
            'user' => $user,
            'article_status_texts' => $book_status_texts,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book, Output $output)
    {
        $user = auth()->user();
        $book = $book->getBook($book->id);
        $output = $output->getOutput($book->id);

        $twitter_share_param = $book->getTwitterSharaParam($book);

        return view('books.show',[
            'user' => $user,
            'book' => $book,
            'output' => $output,
            'twitter_share_param' => $twitter_share_param,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $book_status_texts = $book->getPostBookStatusTexts();
        $user = auth()->user();
        $books = $book->getEditBook($user->id, $book->id);

        if(!isset($books)){
            return redirect('books');
        }
        $tags = [];
        foreach($book->tags as $tag){
            $tags[] = $tag;
        }
        return view('books.edit',[
            'user' => $user,
            'books' => $books,
            'tags'=>$tags,
            'book_status_texts' => $book_status_texts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book, Tag $tag)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => ['required', 'string', 'max:30'],
            'body' => ['string', 'max:20480'],
            'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ]);

        $validator->validate();
        $book->BookUpdate($book->id, $data);

        #カテゴリ名の重複登録を防ぐ
        $storedTagNames = $tag->whereIn('name',$data["tags"])->pluck('name');
        $newTagNames = array_diff($data["tags"],$storedTagNames->all());

        $tag->tagStore($newTagNames);
        $tag_ids = $tag->getTagIds($data["tags"]);
        $article->articleTagSync($tag_ids);

        return redirect('articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book, Request $request)
    {
        $user = auth()->user();
        $book->BookDestroy($user->id, $book->id);
        $redirect = $request->input('redirect');

        if ($redirect == "on") {
            return redirect('/');
        } else {
            return back();
        }
    }
}

