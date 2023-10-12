<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qページ</title>
    <style>
        /* スタイル設定 */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* 上部セクション */
        .top-section {
            background-color:  #f0f0f0;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #ccc;
            position: relative; /* 相対位置に設定 */
        }
        .circle-back-button {
            width: 45px;
            height: 45px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: absolute; /* 絶対位置に設定 */
            top: 10px; /* 上部からの位置 */
            left: 10px;
        }
        .circle-back-button:hover {
            background-color: #ddd;
        }
        /* 真ん中セクション */
        .middle-section {
            text-align: center;
            padding: 20px;

            position: relative; /* 真ん中セクションを相対位置に設定 */
        }

        .speech-bubble {
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            display: inline-block;
            position: relative; /* 吹き出しを相対位置に設定 */
        }

        /* 下部セクション */
        .bottom-section {
            background-color:  #f0f0f0;
            display: flex;
            justify-content: center; /* ボタンを中央寄せに変更 */
            align-items: flex-end;
            height: 150px;
            position: absolute;
            bottom: 0px;
            left: 0;
            right: 0;
            border-top: 1px solid #ccc;
        }

        .button {
            width: 100px;
            height: 100px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="top-section">
        <a button class="circle-back-button" href="/chatmemo" >戻る</a>
        </button>
        会話
    </div>
    
    <div class="middle-section">
        <div class="speech-bubble">
            今日は何について話しますか？
            <div class="tail"></div>
        </div>
    </div>

    <div class="bottom-section">
        <a href="/talk/memo"><div class="button">出来事</div></a>
        <div class="button">予定</div>
        <div class="button">やるべきこと</div>
        <div class="button">考えたこと</div>
    </div>
</body>
</html>
