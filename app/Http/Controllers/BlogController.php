<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
// バリデーション処理を読み込む
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    /**
     *ブログ一覧を表示する
     *
     * @return view
     */
    public function showList()
    {
        $blogs = Blog::all();
        return view('blog.list', ['blogs' => $blogs]);
    }

    /**
     *ブログ詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.detail', ['blog' => $blog]);
    }

    /**
     *ブログ登録画面を表示する
     * @return view
     */
    public function showCreate()
    {
        return view('blog.form');
    }

    /**
     *ブログを登録する
     *
     * @return view
     */
    public function exeStore(BlogRequest $request)
    {
        // ブログのデータを受け取る($request->all()の中身は,$_POSTと同じで連想配列)
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            // ブログを登録
            Blog::create($inputs);
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', 'ブログを登録しました');
        return redirect(route('blogs'));
    }

    /**
     *ブログ編集フォームを表示する
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.edit', ['blog' => $blog]);
    }

    /**
     *ブログを更新する
     *
     *
     */
    public function exeUpdate(BlogRequest $request)
    {
        // ブログのデータを受け取る & バリデーションも実行する
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            // ブログを登録
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content']
            ]);
            $blog->save();
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', 'ブログを更新しました');
        return redirect(route('blogs'));
    }

    /**
     *ブログ削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id)
    {
        if (empty($id)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        try {
            // ブログを削除
            $blog = Blog::destroy($id);
        } catch (\Throwable $e) {
            abort(500);
        }

        \Session::flash('err_msg', 'ブログを削除しました。');
        return redirect(route('blogs'));
    }
}
