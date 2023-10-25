<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Think;
use App\Models\Memo;
use App\Models\Todolist;
use App\Models\Plan;
use DateTime;

class RecordController extends Controller
{
    public function showData()
    {
        // ログインしているユーザーを取得
        $user = Auth::user();

        // 4つのモデルからデータを取得し、unionで結合
        // 各モデルごとにデータを取得
        $thinkData = Think::select('created_at', 'important', 'think_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $memoData = Memo::select('created_at', 'important', 'memo_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $todolistData = Todolist::select('created_at', 'important', 'todo_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $planData = Plan::select('created_at', 'plan_title as title', 'id', 'user_id', 'created_at as date')
            ->where('user_id', $user->id)
            ->get();

        $combinedData = $thinkData->concat($memoData)->concat($todolistData)->concat($planData);

        // 日付でソート
        $sortedData = $combinedData->sortBy('created_at');

         //日付ごとにグループ化
         $groupedData = $sortedData->groupBy(function ($item) {
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

        return view('chatmemo.record')->with(['groupedData'=>$groupedData]);
    }
    
    public function filterByImportance(Request $request)
{
    $importance = $request->input('importance'); // 重要度セレクトメニューからの選択

    $filteredData = []; // 重要度に合致するデータを格納するための配列
    
    $formattedData = [];

    if ($importance === 'yes') {
        // Yes の場合、"important" カラムが "はい" のデータを取得
        $memoData = Memo::where('important', 'はい')->get();
        $todolistData = Todolist::where('important', 'はい')->get();
        $thinkData = Think::where('important', 'はい')->get();
        $planData = Plan::get();
        
        $formattedData = $planData->concat($memoData)->concat($todolistData)->concat($thinkData);
        
    } else if($importance === 'no'){
        // No の場合、"important" カラムが "はい" のデータを除外して取得
        $memoData = Memo::where('important', '!=', 'はい')->get();
        $todolistData = Todolist::where('important', '!=', 'はい')->get();
        $thinkData = Think::where('important', '!=', 'はい')->get();
        
        $formattedData = $memoData->concat($todolistData)->concat($thinkData);
        
    } else if($importance === 'all'){
        $planData = Plan::get();
        $memoData = Memo::get();
        $todolistData = Todolist::get();
        $thinkData = Think::get();
        
        $formattedData = $planData->concat($memoData)->concat($todolistData)->concat($thinkData);
    }
    
    $sorteddivideData = $formattedData->sortBy('created_at');
    
    $groupedformData = $sorteddivideData->groupBy(function ($item) {
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
    
    return response()->json($groupedformData);

    // 重要度に合致するデータをJSON レスポンスとして返す
    }
    
    public function filterByCategory(Request $request)
{
    $category = $request->input('category'); // 重要度セレクトメニューからの選択

    $filteredData = []; // 重要度に合致するデータを格納するための配列
    
    $formattedData = [];

    if ($category === 'memo') {
        
        $memoData = Memo::get();
        
        $formattedData = $memoData;
        
    } else if($category === 'plan'){
        
        $planData = Plan::get();
        
        $formattedData = $planData;
        
    } else if($category === 'todo'){
        
        $todolistData = Todolist::get();
        
        $formattedData = $todolistData;
        
    } else if($category === 'think'){
        
        $thinkData = Think::get();
    
        $formattedData = $thinkData;
        
    } else if($category === 'all'){
        $planData = Plan::get();
        $memoData = Memo::get();
        $todolistData = Todolist::get();
        $thinkData = Think::get();
        
        $formattedData = $planData->concat($memoData)->concat($todolistData)->concat($thinkData);
    }
    
    $sorteddivideData = $formattedData->sortBy('created_at');
    
    $groupedformData = $sorteddivideData->groupBy(function ($item) {
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
    
    return response()->json($groupedformData);

    // 重要度に合致するデータをJSON レスポンスとして返す
    }

    public function memoEdit(Memo $memo)
    {
        $url = $memo->url ?? "ない";
        
        return view('chatmemo.edit_memo')->with(['memo' => $memo, 'url' => $url]);
    }
    public function planEdit(Plan $plan)
    {
        $url = $plan->url ?? "ない";
        
        $when_planDate = $plan->when_plan;
        
         // 新しいDateTimeオブジェクトを作成
        $dateTime = new DateTime($when_planDate);
        
         // 日時情報をフォーマット
        $formattedDate = $dateTime->format('Y年n月j日G時i分');
        
        return view('chatmemo.edit_plan')->with(['plan' => $plan, 'url' => $url, 'formattedDate'=> $formattedDate]);
    }

    public function todoEdit(Todolist $todo)
    {
        $url = $todo->url ?? "ない";
        
        $when_todoDate = $todo->when_todo;
        
         // 新しいDateTimeオブジェクトを作成
        $dateTime = new DateTime($when_todoDate);
        
         // 日時情報をフォーマット
        $formattedDate = $dateTime->format('Y年n月j日G時i分');
        
        return view('chatmemo.edit_todo')->with(['todo' => $todo, 'url' => $url, 'formattedDate'=> $formattedDate]);
    }

    public function thinkEdit(Think $think)
    {
        $url = $think->url ?? "ない";
        
        return view('chatmemo.edit_think')->with(['think' => $think, 'url' => $url]);
    }
}
