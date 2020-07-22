<?php

namespace App\Http\Controllers;

use App\Models\Entity\Tag;
use App\Models\Entity\User;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Tag $tag, User $user)
    {
        // $popular_tags = $tag->getPopularTags();
        // $popular_users = $user->getPopularUsers();
        // $api = "/fetch?mode=tag&tag_id={$tag->id}";
        // return view('tags.show',[
        //     'tag' => $tag,
        //     'api' => $api,
        //     'popular_tags' => $popular_tags,
        //     'popular_users' => $popular_users,
        // ]);
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
