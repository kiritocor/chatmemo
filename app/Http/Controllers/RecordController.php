<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Models\Think;
use App\Models\User;
use App\Models\Memo;
use App\Models\Todolist;
use App\Models\Plan;
use Illuminate\Pagination\LengthAwarePaginator;


class RecordController extends Controller
{
    public function showData()
{
    // ログインしているユーザーを取得
    $user = Auth::user();

    // 4つのモデルからデータを取得し、unionで結合
    $combinedData = Think::select('created_at','think_title')
        ->where('user_id', $user->id)
        ->unionAll(Memo::select('created_at','memo_title')->where('user_id', $user->id))
        ->unionAll(Todolist::select('created_at','todo_title')->where('user_id', $user->id))
        ->unionAll(Plan::select('created_at','plan_title')->where('user_id', $user->id))
        ->get();

    // 日付でソート
    $sortedData = $combinedData->sortBy('created_at');

    // ページネーションを追加
    $perPage = 30; // 1ページあたりの表示件数
    $currentPage = request()->get('page', 1); // 現在のページ
    $pagedData = $this->paginate($sortedData, $perPage, $currentPage);

    // 日付ごとにグループ化
    $groupedData = $pagedData->groupBy(function ($item) {
        return $item->created_at->format('Y');
    })->map(function ($yearItems) {
        return $yearItems->groupBy(function ($item) {
            return $item->created_at->format('m月');
        })->map(function ($monthYearItems) {
            return $monthYearItems->groupBy(function ($item) {
                return $item->created_at->format('d日');
            });
        });
    });

    return view('chatmemo.record', compact('groupedData', 'pagedData'));
}

private function paginate($items, $perPage, $page)
{
    $offset = ($page - 1) * $perPage;
    return new LengthAwarePaginator(
        $items->slice($offset, $perPage),
        $items->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );
}
}