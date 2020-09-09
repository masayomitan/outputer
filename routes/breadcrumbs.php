<?php


use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;



Breadcrumbs::for('books.index', function ($trail) {
    $trail->push('本の一覧', route('books.index'));
});


//本に関するパンくず==================================
Breadcrumbs::for('books.show', function ($trail, $book) {
    $trail->parent('books.index');
    $trail->push("$book->title のまとめ一覧", url('books/'. $book->id));
});
Breadcrumbs::for('books.create', function ($trail) {
    $trail->parent('books.index');
    $trail->push("本の作成", route('books.create'));
});
Breadcrumbs::for('books.put_new_sentence', function ($trail) {
    $trail->parent('books.index');
    $trail->push("新しくまとめられた本", route('books.put_new_sentence'));
});
Breadcrumbs::for('books.put_popular_sentence', function ($trail) {
    $trail->parent('books.index');
    $trail->push("まとめが多い順", route('books.put_popular_sentence'));
});
//ここまで==========================================


//ユーザーに関するパンくず============================
Breadcrumbs::for('users.show', function ($trail, $user) {
    $trail->parent('books.index', $user);
    $trail->push("$user->name",  url('users/'. $user->id));
});
Breadcrumbs::for('users.edit', function ($trail, $user) {
    $trail->parent('users.show', $user);
    $trail->push("ユーザー編集");
});
//ここまで==========================================


//3行まとめ作成セット=================================
Breadcrumbs::for('books.show_to_sentence', function ($trail, $book) {
    $trail->parent('books.index');
    $trail->push("$book->title のまとめ一覧", url('books/'. $book->id));
});
Breadcrumbs::for('sentences.create', function ($trail, $book) {
    $trail->parent('books.show_to_sentence', $book);
    $trail->push('まとめ作成', url('sentences/create/'));
});
//ここまで==========================================


//まとめeditパンくずセット============================
Breadcrumbs::for('sentence.show', function ($trail, $user, $book, $sentences) {
    $trail->parent('books.index',$user, $book, $sentences);
    $trail->push("「 $book->title 」のまとめ一覧",  route('books.show',$sentences->book_id));
});
Breadcrumbs::for('user.show_to_edit', function ($trail, $user, $book, $sentences) {
    $trail->parent('sentence.show',$user, $book, $sentences);
    $trail->push("$user->name",  url('users/'. $user->id));
});
Breadcrumbs::for('sentence.edit', function ($trail, $user, $book, $sentences){
    $trail->parent('user.show_to_edit', $user, $book, $sentences );
    $trail->push('まとめ編集');
});
//ここまで==========================================


//タグに関するパンくず================================
Breadcrumbs::for('tags.index', function ($trail, $tags) {
    $trail->parent('books.index');
    $trail->push('タグ一覧', route('tags.index'));
});
Breadcrumbs::for('tags.show', function ($trail, $tags) {
    $trail->parent('books.index');
    $trail->push("$tags->name",  url('tags/'. $tags->id));
});
//ここまで==========================================
