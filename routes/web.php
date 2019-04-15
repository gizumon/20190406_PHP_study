<?php

use App\Book;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', ['middleware' => 'auth', function () {
    $books = Book::all();
    return view('books',[
        "books" => $books
    ]);
}]);

Route::post('/book', ['middleware' => 'auth',  function (Request $request) {
    $validator = Validator::make($request->all(),[
        'name' => 'required|max:255',
    ]);

    if($validator->fails()){
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $book = new Book; //ORM
    $book->title = $request->name;
    $book->save();

    return redirect('/');
}]);

//{id}で囲んだ値を取得し、$idに格納
Route::delete('/book/{book}', ['middleware' => 'auth',  function (Book $book) {
    $book->delete();

    return redirect('/');    
}]);
