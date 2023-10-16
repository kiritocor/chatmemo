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
    // Memoモデルにデータを保存
    $plan->user_id = $user->id;
    $plan->memo_title = $data['question1'];
    $plan->about = $data['question4'];
    $plan->important = $data['question3'];
    $plan->w_think = $data['question5'];
    $memo->tag_id = 3;
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
    // Memoモデルにデータを保存
    $Todo->user_id = $user->id;
    $Todo->todo_title = $data['question1'];
    $Todo->about = $data['question4'];
    $Todo->important = $data['question3'];
    $Todo->w_think = $data['question5'];
    $memo->tag_id = 2;
    $Todo->save();

    
    // // Memoモデルに保存したデータのIDを取得
    $TodoID = $Todo->id;

      //$data['question2'] の内容に応じてデータを保存
           if (filter_var($data['question2'], FILTER_VALIDATE_URL)) {
            
           // "http://"または"https://"プロトコルを持つ正当なURLの場合、Link モデルに保存
               $link = new Link();
               $link->url = $data['question2'];
               $link->todolist_id = $TodoID;
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
    $think->about = $data['question4'];
    $think->important = $data['question3'];
    $think->w_think = $data['question5'];
    $memo->tag_id = 1;
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
