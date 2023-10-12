<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatmemo;

class ChatmemoController extends Controller
{
    public function top(Chatmemo $chatmemo)//インポートしたPostをインスタンス化して$postとして使用。
{
   return view('chatmemo.top');
}

}
