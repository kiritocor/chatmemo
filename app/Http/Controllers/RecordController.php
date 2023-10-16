<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Think;
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
        // 各モデルごとにデータを取得
        $thinkData = Think::select('created_at', 'think_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $memoData = Memo::select('created_at', 'memo_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $todolistData = Todolist::select('created_at', 'todo_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $planData = Plan::select('created_at', 'plan_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $combinedData = $thinkData->concat($memoData)->concat($todolistData)->concat($planData);

        // 日付でソート
        $sortedData = $combinedData->sortBy('created_at');

        // ページネーションを追加
        $perPage = 5; // 1ページあたりの表示件数
        $currentPage = request()->get('page', 1); // 現在のページ

        // ページネーション情報を取得
        $total = $sortedData->count();

        $offset = ($currentPage - 1) * $perPage;
        $pagedData = $sortedData->slice($offset, $perPage);
        $pagedRecordDetails = new LengthAwarePaginator(
            $pagedData,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
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

        return view('chatmemo.record', compact('groupedData', 'pagedRecordDetails'));
    }

    private function getRecordDetails($sortedData, $perPage, $page)
    {
        $offset = ($page - 1) * $perPage;

        // ページネーションを実行
        $pagedData = $sortedData->splice($offset, $perPage);

        // ページネーション情報を取得
        $total = $sortedData->count() + count($pagedData);
        $paginator = new LengthAwarePaginator($pagedData, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return $paginator;
    }

    public function memoEdit(Memo $memo)
    {
        $url = $memo->url ?? "ない";
        
        return view('chatmemo.edit_memo')->with(['memo' => $memo, 'url' => $url]);
    }

    public function planEdit(Think $think)
    {
        $url = $memo->url ?? "ない";
        
        return view('chatmemo.edit_think')->with(['think' => $think, 'url' => $url]);
    }

    public function todoEdit(Plan $plan)
    {
        $url = $memo->url ?? "ない";
        
        return view('chatmemo.edit_plan')->with(['plan' => $plan, 'url' => $url]);
    }

    public function thinkEdit(Todolist $todo)
    {
        $url = $memo->url ?? "ない";
        
        return view('chatmemo.edit_memo')->with(['todo' => $todo, 'url' => $url]);
    }
}
