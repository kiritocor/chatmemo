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

public function updateMessage(Request $request, Memo $memo) {
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

}
