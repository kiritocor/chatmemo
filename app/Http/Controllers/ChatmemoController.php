<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Think;
use App\Models\Memo;
use App\Models\Todolist;
use App\Models\Plan;
use DateTime;


class ChatmemoController extends Controller
{
    public function top()
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

        $todolistData = Todolist::select('created_at', 'important', 'todo_title as title', 'id', 'user_id', 'when_todo','created_at as date', 'sorve')
            ->where('user_id', $user->id)
            ->get();

        $planData = Plan::select('created_at', 'plan_title as title', 'id', 'user_id', 'when_plan', 'created_at as date', 'sorve')
            ->where('user_id', $user->id)
            ->get();

        $combinedData = $thinkData->concat($memoData)->concat($todolistData)->concat($planData);

        // 日付でソート
        
        $sortedwhenplanData = $planData->where('sorve', '!=', 'sorve')->sortBy('when_plan');
        
        $sortedwhentodoData = $todolistData->where('sorve', '!=', 'sorve')->sortBy('when_todo');
        
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
        
        //日付ごとにグループ化
         $sortedplanData = $memoData->groupBy(function ($item) {
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
        
        //日付ごとにグループ化
         $sortedtodoData = $thinkData->groupBy(function ($item) {
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
        
        
        

        return view('chatmemo.top')->with([
            'groupedData'=>$groupedData, 
            'sortedplanData'=>$sortedplanData, 
            'sortedtodoData'=>$sortedtodoData, 
            'sortedwhenplanData'=>$sortedwhenplanData, 
            'sortedwhentodoData'=>$sortedwhentodoData
            ]);
            
}

public function fetchDateData(Request $request)
    {
        $user = Auth::user();
        
        $date = $request->input('date');

        $planData = Plan::whereDate('when_plan', '=', $date)->where('user_id', $user->id)->pluck('plan_title')->toArray();
        $todoData = Todolist::whereDate('when_todo', '=', $date)->where('user_id', $user->id)->pluck('todo_title')->toArray();
        $response = array_merge($planData, $todoData);

        return response()->json($response);
    }

public function updateSorve(Request $request) {
    
     // ログインしているユーザーを取得
        $user = Auth::user();
        
    // AjaxリクエストからrecordIdを取得
    $recordId = $request->input('recordId');
    $tagId = $request->input('tagId');

   if ($tagId == 2) {
        $todo = Todolist::where('id', $recordId)->where('user_id', $user->id)->first();
        
            $todo->sorve = 'sorve';
            $todo->save();
            return response()->json(['success' => true]);
        
    } elseif ($tagId == 3) {
        $plan = Plan::where('id', $recordId)->where('user_id', $user->id)->first();
        
            $plan->sorve = 'sorve';
            $plan->save();
            return response()->json(['success' => true]);
        
    }

    return response()->json(['success' => false]);
}

public function updateunSorve(Request $request) {
    
     // ログインしているユーザーを取得
        $user = Auth::user();
        
    // AjaxリクエストからrecordIdを取得
    $recordId = $request->input('recordId');
    $tagId = $request->input('tagId');

   if ($tagId == 2) {
        $todo = Todolist::where('id', $recordId)->where('user_id', $user->id)->first();
        
            $todo->sorve = 'unsorve';
            $todo->save();
            return response()->json(['success' => true]);
        
    } elseif ($tagId == 3) {
        $plan = Plan::where('id', $recordId)->where('user_id', $user->id)->first();
        
            $plan->sorve = 'unsorve';
            $plan->save();
            return response()->json(['success' => true]);
        
    }

    return response()->json(['success' => false]);
}

public function filterByunSorve()
{
     // ログインしているユーザーを取得
        $user = Auth::user();

        $todolistData = Todolist::select('created_at', 'important', 'todo_title as title', 'id', 'user_id', 'when_todo','created_at as date', 'sorve')
            ->where('user_id', $user->id)
            ->where('sorve', '!=', 'sorve') // 解決済みでないデータを取得
        ->orderBy('when_todo')
        ->get();

        $planData = Plan::select('created_at', 'plan_title as title', 'id', 'user_id', 'when_plan', 'created_at as date', 'sorve')
            ->where('user_id', $user->id)
            ->where('sorve', '!=', 'sorve') // 解決済みでないデータを取得
        ->orderBy('when_plan')
        ->get();
        
        
         $formattedPlanData = $planData->map(function ($item) {
        $formattedWhenPlan = date('Y年n月j日G時i分', strtotime($item->when_plan));
        $item->formatted_when_plan = $formattedWhenPlan;
        return $item;
    });
        
        
        $formattedTodoData = $todolistData->map(function ($item) {
        $formattedWhenTodo = date('Y年n月j日G時i分', strtotime($item->when_todo));
        $item->formatted_when_todo = $formattedWhenTodo;
        return $item;
    });

    
        return response()->json([
           'sortedwhenplanData' => $formattedPlanData,
        'sortedwhentodoData' => $formattedTodoData,
            ]);
}

public function filterBySorve()
{// ログインしているユーザーを取得
        $user = Auth::user();

        $todolistData = Todolist::select('created_at', 'important', 'todo_title as title', 'id', 'user_id', 'when_todo','created_at as date', 'sorve')
            ->where('user_id', $user->id)
            ->where('sorve', '!=', 'unsorve')
            ->get();

        $planData = Plan::select('created_at', 'plan_title as title', 'id', 'user_id', 'when_plan', 'created_at as date', 'sorve')
            ->where('user_id', $user->id)
            ->where('sorve', '!=', 'unsorve')
            ->get();
        
        //日付ごとにグループ化
         $sortedplanData = $planData->groupBy(function ($item) {
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
        
        //日付ごとにグループ化
         $sortedtodoData = $todolistData->groupBy(function ($item) {
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
        
        
        

        return response()->json([
            'sortedplanData'=>$sortedplanData, 
            'sortedtodoData'=>$sortedtodoData, 
            ]);
}

}
