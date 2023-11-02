<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Think;
use App\Models\Memo;
use App\Models\Todolist;
use App\Models\Plan;
use App\Models\Tag;
use App\Models\TagPost;
use DateTime;

class RecordController extends Controller
{
    public function showData()
    {
        // ログインしているユーザーを取得
        $user = Auth::user();

        // 4つのモデルからデータを取得し、unionで結合
        // 各モデルごとにデータを取得
        $thinkData = Think::select('created_at', 'important', 'think_title as title', 'id', 'user_id', 'created_at as date', 'tag_id')
            ->where('user_id', $user->id)
            ->get();

        $memoData = Memo::select('created_at', 'important', 'memo_title as title', 'id', 'user_id', 'created_at as date', 'tag_id')
            ->where('user_id', $user->id)
            ->get();

        $todolistData = Todolist::select('created_at', 'important', 'todo_title as title', 'id', 'user_id', 'created_at as date', 'tag_id')
            ->where('user_id', $user->id)
            ->get();

        $planData = Plan::select('created_at', 'plan_title as title', 'id', 'user_id', 'created_at as date', 'tag_id')
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
        
        $tagData = Tag::where('user_id', $user->id)->get();

        return view('chatmemo.record')->with(['groupedData'=>$groupedData, 'tagData'=>$tagData]);
    }
    
    public function savetag(Request $request,Tag $tag)
{
    $data = $request->json()->all();
    $user = Auth::user();
    // Memoモデルにデータを保存
    
    foreach ($data['messages'] as $message) {
    $tag = new Tag;
    $tag->user_id = $user->id;
    $tag->name = $message;
    $tag->save();
    }
    return response()->json(['message' => 'Message saved successfully']);
}
    
    public function attachTagToPost(Request $request) 
{
    $user = Auth::user();
    
    $recordId = $request->input('recordId');
    $tagId = $request->input('tagId');
    $filterId = $request->input('filterId');

    // 中間テーブルにデータを保存する処理を実装
    
    $tagPost = new TagPost;
    $tagPost->user_id = $user->id;
    $tagPost->record_id = $recordId;
    $tagPost->tag_id = $tagId;
    $tagPost->record_type = $filterId;
    $tagPost->save();

    return response()->json(['success' => true]);
}

public function deleteTagPost($id) {
    // $id を使用して該当の投稿を削除する処理を実装
    $tagPost = TagPost::find($id);
    if (!$tagPost) {
        return response()->json(['success' => false]);
    }
    
    $tagPost->delete();
    
    return response()->json(['success' => true]);
}
    
    public function filterByImportance(Request $request)
{
    
    $user = Auth::user();
    
    $importance = $request->input('importance'); // 重要度セレクトメニューからの選択

    $filteredData = []; // 重要度に合致するデータを格納するための配列
    
    $formattedData = [];

    if ($importance === 'yes') {
        // Yes の場合、"important" カラムが "はい" のデータを取得
        $memoData = Memo::where('user_id', $user->id)->where('important', 'はい')->get();
        $todolistData = Todolist::where('user_id', $user->id)->where('important', 'はい')->get();
        $thinkData = Think::where('user_id', $user->id)->where('important', 'はい')->get();
        $planData = Plan::where('user_id', $user->id)->get();
        
        $formattedData = $planData->concat($memoData)->concat($todolistData)->concat($thinkData);
        
    } else if($importance === 'no'){
        // No の場合、"important" カラムが "はい" のデータを除外して取得
        $memoData = Memo::where('user_id', $user->id)->where('important', '!=', 'はい')->get();
        $todolistData = Todolist::where('user_id', $user->id)->where('important', '!=', 'はい')->get();
        $thinkData = Think::where('user_id', $user->id)->where('important', '!=', 'はい')->get();
        
        $formattedData = $memoData->concat($todolistData)->concat($thinkData);
        
    } else if($importance === 'all'){
        $planData = Plan::where('user_id', $user->id)->get();
        $memoData = Memo::where('user_id', $user->id)->get();
        $todolistData = Todolist::where('user_id', $user->id)->get();
        $thinkData = Think::where('user_id', $user->id)->get();
        
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
    $user = Auth::user();
    
    $category = $request->input('category'); // 重要度セレクトメニューからの選択

    $filteredData = []; // 重要度に合致するデータを格納するための配列
    
    $formattedData = [];

    if ($category === 'memo') {
        
        $memoData = Memo::where('user_id', $user->id)->get();
        
        $formattedData = $memoData;
        
    } else if($category === 'plan'){
        
        $planData = Plan::where('user_id', $user->id)->get();
        
        $formattedData = $planData;
        
    } else if($category === 'todo'){
        
        $todolistData = Todolist::where('user_id', $user->id)->get();
        
        $formattedData = $todolistData;
        
    } else if($category === 'think'){
        
        $thinkData = Think::where('user_id', $user->id)->get();
    
        $formattedData = $thinkData;
        
    } else if($category === 'all'){
        $planData = Plan::where('user_id', $user->id)->get();
        $memoData = Memo::where('user_id', $user->id)->get();
        $todolistData = Todolist::where('user_id', $user->id)->get();
        $thinkData = Think::where('user_id', $user->id)->get();
        
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
    
    public function search(Request $request)
{
    $query = $request->input('query');
    
    $user = Auth::user();
    
    // データベースから予測結果を取得
$thinkResults = Think::where('user_id', $user->id)->where('think_title', 'like', '%' . $query . '%')->limit(10)->get();
$memoResults = Memo::where('user_id', $user->id)->where('memo_title', 'like', '%' . $query . '%')->limit(10)->get();
$todolistResults = Todolist::where('user_id', $user->id)->where('todo_title', 'like', '%' . $query . '%')->limit(10)->get();
$planResults = Plan::where('user_id', $user->id)->where('plan_title', 'like', '%' . $query . '%')->limit(10)->get();

$results = $thinkResults->concat($memoResults)->concat($todolistResults)->concat($planResults);

$sortedData = $results->sortBy('created_at');

$searchData = $sortedData->groupBy(function ($item) {
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

    return response()->json($searchData);
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
