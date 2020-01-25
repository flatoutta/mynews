<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;
// lesson17 以下二行
use App\History;

use Carbon\Carbon;

class NewsController extends Controller
{
  public function add()
  {
    return view('admin.news.create');
  }
  
  public function create(Request $request)
  {
    $this->validate($request, News::$rules);
    
    $news = new News;
    $form = $request->all();

// フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する    
    if (isset($form['image'])) {
      $path = $request->file('image')->store('public/image');
      $news->image_path = basename($path);
    }else{
      $news->image_path = null;
    }

    unset($form['_token']);
    unset($form['image']);

    $news->fill($form);
    $news->save();
    
    return redirect('admin/news/create');
  }
  public function index(Request $request)
  {
    $cond_title = $request->cond_title;
    if ($cond_title != '') {
      // 検索されたら検索結果を取得する
      $posts = News::where('title', $cond_title)->get();
    } else {

      $posts = News::all();
    }
    return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  
  public function edit(Request $request)
  {
    $news = News::find($request->id);
    if (empty($news)) {
      abort(404);
    }
    return view('admin.news.edit', ['news_form' => $news]);
  }
  
  public function update(Request $request)
  {
    $this->validate($request, News::$rules);
    $news = News::find($request->id);
    $form = $request->all();

    if (isset($form['image'])) {
      $path = $request->file('image')->store('public/image');
      $news->image_path = basename($path);
      unset($form['image']);
    }elseif(isset($form['remove'])) {
      $news->image_path = null;
      unset($form['remove']);
    }
    unset($form['_token']);

    $news->fill($form)->save();
    
    // lesson17で以下追加
    $history = new History;
    $history->news_id = $news->id;
    $history->edited_at = Carbon::now();
    $history->save();
    
    return redirect('admin/news/');
  }
  
  public function delete(Request $request)
  {
      $news = News::find($request->id);
      $news->delete();
      return redirect('admin/news/');
  }  
  
  
}
