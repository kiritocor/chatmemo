<?php

namespace App\Http\Controllers;

use App\Models\Talk_memo;
use App\Models\Link;
use App\Models\Memo;
use App\Models\Photo;
use Illuminate\Http\Request;

class TalkController extends Controller
{
    public function saveMessage(Request $request,Memo $memo, Link $link )
{
    $data = $request->json()->all();
    $user=auth()->user();
    // Memoモデルにデータを保存
    $memo->user_id = $user->id;
    $memo->memo_title = $data['question1'];
    $memo->about = $data['question4'];
    $memo->important = $data['question3'];
    $memo->w_think = $data['question5'];
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
}
