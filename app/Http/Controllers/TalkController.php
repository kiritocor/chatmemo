<?php

namespace App\Http\Controllers;

use App\Models\Talk_memo;
use App\Models\Link;
use App\Models\Memo;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Http\Request;

class TalkController extends Controller
{
    public function saveMemoMessage(Request $request,Memo $memo, )
{
    $data = $request->json()->all();
    $user=auth()->user();
    // Memoモデルにデータを保存
    $memo->user_id = $user->id;
    $memo->memo_title = $data['question1'];
    $memo->about = $data['question4'];
    $memo->important = $data['question3'];
    $memo->w_think = $data['question5'];
    $memo->tag_id = 4;
    $memo->save();

    
    // // Memoモデルに保存したデータのIDを取得
    $memoID = $memo->id;

      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($data['question2'], FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = $data['question2'];
               $link->memo_id = $memoID;
               $link->save();
           } elseif (is_string($data['question2']) && file_exists($data['question2'])) {
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = $data['question2'];
               $photo->memo_id = $memoID;
               $photo->save();
           }
    
    return response()->json(['message' => 'Message saved successfully']);
}

public function savePlanMessage(Request $request,Plan $plan, Link $link )
{
    $data = $request->json()->all();
    $user=auth()->user();
    
    // ユーザが提供した日付文字列
$dateString = $data['question3'];

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

// Eloquentモデルを使用してデータベースに保存
    $plan->when_plan = $date;
}

    $plan->user_id = $user->id;
    $plan->plan_title = $data['question1'];
    $plan->where = $data['question4'];
    $plan->w_think = $data['question5'];
    $plan->plan_detail = $data['question6'];
    $plan->tag_id = 3;
    $plan->save();

    
    // // Memoモデルに保存したデータのIDを取得
    $planID = $plan->id;

      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($data['question2'], FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = $data['question2'];
               $link->plan_id = $planID;
               $link->save();
           } elseif (is_string($data['question2']) && file_exists($data['question2'])) {
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = $data['question2'];
               $photo->plan_id = $planID;
               $photo->save();
           }
    
    return response()->json(['message' => 'Message saved successfully']);
}

public function saveTodoMessage(Request $request,Todolist $Todo, Link $link )
{
    $data = $request->json()->all();
    $user=auth()->user();
    
    // ユーザが提供した日付文字列
$dateString = $data['question6'];

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

// Eloquentモデルを使用してデータベースに保存
    $todo->when_todo = $date;
}
    $todo->user_id = $user->id;
    $todo->todo_title = $data['question1'];
    $todo->about = $data['question3'];
    $todo->important = $data['question4'];
    $todo->w_think = $data['question5'];
    $todo->tag_id = 2;
    $todo->save();

    
    // // Memoモデルに保存したデータのIDを取得
    $todoID = $todo->id;

      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($data['question2'], FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = $data['question2'];
               $link->todolist_id = $todoID;
               $link->save();
           } elseif (is_string($data['question2']) && file_exists($data['question2'])) {
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = $data['question2'];
               $photo->todolist_id = $TodoID;
               $photo->save();
           }
    
    return response()->json(['message' => 'Message saved successfully']);
}

public function saveThinkMessage(Request $request,Think $think, Link $link )
{
    $data = $request->json()->all();
    $user=auth()->user();
    // Memoモデルにデータを保存
    $think->user_id = $user->id;
    $think->think_title = $data['question1'];
    $think->when = $data['question3'];
    $think->important = $data['question4'];
    $think->about = $data['question5'];
    $think->w_think = $data['question6'];
    $think->tag_id = 1;
    $think->save();

    
    // 
    $thinkID = $think->id;

      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($data['question2'], FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = $data['question2'];
               $link->think_id = $thinkID;
               $link->save();
           } elseif (is_string($data['question2']) && file_exists($data['question2'])) {
               // $data['question2'] がファイルパスの場合、Photo モデルに保存
               $photo = new Photo();
               $photo->file_path = $data['question2'];
               $photo->think_id = $thinkID;
               $photo->save();
           }
    
    return response()->json(['message' => 'Message saved successfully']);
}
}
