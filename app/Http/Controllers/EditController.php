<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Think;
use App\Models\User;
use App\Models\Memo;
use App\Models\Todolist;
use App\Models\Plan;
use Illuminate\Http\Request;

class EditController extends Controller
{

public function updateMemoMessage(Request $request, Memo $memo) {
    $user=auth()->user();
    $memo->user_id = $user->id;
    $editedMessage = $request->json()->all();
    // メモの内容を更新
    $memo->fill([
        'memo_title' => $editedMessage['question1'],
        'important' => $editedMessage['question3'],
        'about' => $editedMessage['question4'],
        'w_think' => $editedMessage['question5'],
    ]);
    
    $memo->save();
    
     // // Memoモデルに保存したデータのIDを取得
    $memoID = $memo->id;
    
    $requestData = $editedMessage['question2'];
      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($requestData, FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = fill($requestData);
               $link->memo_id = $memoID;
               $link->save();
           } elseif (is_string($requestData) && file_exists($requestData)){
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = fill($requestData);
               $photo->memo_id = $memoID;
               $photo->save();
           }

    return response()->json(['message' => 'メモが更新されました'], 200);
}

public function updateThinkMessage(Request $request, Think $think) {
    $user=auth()->user();
    $think->user_id = $user->id;
    $editedMessage = $request->json()->all();
    // メモの内容を更新
    $think->fill([
        'think_title' => $editedMessage['question1'],
        'when' => $editedMessage['question3'],
        'important' => $editedMessage['question4'],
        'about' => $editedMessage['question5'],
        'w_think' => $editedMessage['question6'],
    ]);
    
    $think->save();
    
     // // Memoモデルに保存したデータのIDを取得
    $thinkID = $think->id;
    
    $requestData = $editedMessage['question2'];
      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($requestData, FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = fill($requestData);
               $link->think_id = $thinkID;
               $link->save();
           } elseif (is_string($requestData) && file_exists($requestData)){
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = fill($requestData);
               $photo->think_id = $thinkID;
               $photo->save();
           }

    return response()->json(['message' => 'メモが更新されました'], 200);
}

public function updatePlanMessage(Request $request, Plan $plan) {
    $user=auth()->user();
    $plan->user_id = $user->id;
    $editedMessage = $request->json()->all();
    
    // ユーザが提供した日付文字列
$dateString = $editedMessage['question3'];

if ($dateString !== "なし") {
// 正規表現を使用して年、月、日、時、分を抽出
preg_match('/(\d+)年(\d+)月(\d+)日(\d+)時(\d+)分/', $dateString, $matches);

$year = $matches[1];
$month = $matches[2];
$day = $matches[3];
$hour = $matches[4];
$minute = $matches[5];

// Carbonライブラリを使用してtimestampを生成
$date = \Carbon\Carbon::create($year, $month, $day, $hour, $minute);
}

    // メモの内容を更新
    $plan->fill([
        'when_plan' => $date,
        'plan_title' => $editedMessage['question1'],
        'where' => $editedMessage['question4'],
        'w_think' => $editedMessage['question5'],
        'plan_detail' => $editedMessage['question6'],
    ]);
    
    $plan->save();
    
     // // Memoモデルに保存したデータのIDを取得
    $planID = $plan->id;
    
    $requestData = $editedMessage['question2'];
      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($requestData, FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = fill($requestData);
               $link->plan_id = $planID;
               $link->save();
           } elseif (is_string($requestData) && file_exists($requestData)){
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = fill($requestData);
               $photo->plan_id = $planID;
               $photo->save();
           }

    return response()->json(['message' => 'メモが更新されました'], 200);
}

public function updateTodoMessage(Request $request, Todolist $todo) {
    $user=auth()->user();
    $todo->user_id = $user->id;
    $editedMessage = $request->json()->all();
    
    // ユーザが提供した日付文字列
$dateString = $editedMessage['question6'];

if ($dateString !== "なし") {
// 正規表現を使用して年、月、日、時、分を抽出
preg_match('/(\d+)年(\d+)月(\d+)日(\d+)時(\d+)分/', $dateString, $matches);

$year = $matches[1];
$month = $matches[2];
$day = $matches[3];
$hour = $matches[4];
$minute = $matches[5];

// Carbonライブラリを使用してtimestampを生成
$date = \Carbon\Carbon::create($year, $month, $day, $hour, $minute);
}

    // メモの内容を更新
    $todo->fill([
        'when_todo' => $date,
        'todo_title' => $editedMessage['question1'],
        'about' => $editedMessage['question3'],
        'important' => $editedMessage['question4'],
        'w_think' => $editedMessage['question5'],
    ]);
    
    $todo->save();
    
     // // Memoモデルに保存したデータのIDを取得
    $todoID = $todo->id;
    
    $requestData = $editedMessage['question2'];
      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($requestData, FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = fill($requestData);
               $link->todo_id = $todoID;
               $link->save();
           } elseif (is_string($requestData) && file_exists($requestData)){
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = fill($requestData);
               $photo->todo_id = $todoID;
               $photo->save();
           }

    return response()->json(['message' => 'メモが更新されました'], 200);
}

public function deleteMemo($id) {
    // $id を使用して該当の投稿を削除する処理を実装
    $deletepost = Memo::find($id);
    if (!$deletepost) {
        return response()->json(['success' => false]);
    }
    
    $deletepost->delete();
    
    return response()->json(['success' => true]);
}

public function deletePlan($id) {
    // $id を使用して該当の投稿を削除する処理を実装
    $deletepost = Plan::find($id);
    if (!$deletepost) {
        return response()->json(['success' => false]);
    }
    
    $deletepost->delete();
    
    return response()->json(['success' => true]);
}

public function deleteTodo($id) {
    // $id を使用して該当の投稿を削除する処理を実装
    $deletepost = Todolist::find($id);
    if (!$deletepost) {
        return response()->json(['success' => false]);
    }
    
    $deletepost->delete();
    
    return response()->json(['success' => true]);
}

public function deleteThink($id) {
    // $id を使用して該当の投稿を削除する処理を実装
    $deletepost = Think::find($id);
    if (!$deletepost) {
        return response()->json(['success' => false]);
    }
    
    $deletepost->delete();
    
    return response()->json(['success' => true]);
}

}
