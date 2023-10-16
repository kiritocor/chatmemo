<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrolln</title>
    <style>
        /* 全体のコンテナ */
        .container {
            display: flex;
            flex-direction: column;
            height: 100vh; /* 画面の高さいっぱいに表示 */
        }

        /* 上部セクション */
        .top {
            background-color: #f0f0f0;
            padding: 10px;
            position: sticky;
            top: 0;
            z-index: 2; /* 他の要素の上に表示 */
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }
        
        .divider {
            border-top: 1px solid black;
            height: 100%; /* 要素の高さいっぱいに線を引く */
            position: absolute; /* 絶対位置指定 */
            top: 0;
        }

        /* 区切り線をセレクトメニュー1とセレクトメニュー2の間に挿入 */
        .select-menu + .divider {
            margin-left: 10px;
            margin-right: 10px;
        }

        /* 丸形のボタンスタイル */
        .circle-back-button {
            width: 60px;
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
        }
        .circle-back-button:hover {
            background-color: #ddd;
        }
        .select-menu {
            margin: 0 10px;
        }

         /* 区切り線スタイル */
          .divider {
            border-top: 1px solid #ccc;
            margin: 0px 0;
        }

        /* 中央セクション */
        .middle {
            flex-grow: 1; /* 空きスペースを埋める */
            overflow-y: scroll; /* 縦スクロールを有効にする */
            padding: 10px;
        }

        /* 下部セクション */
        .bottom {
            height: 80px;
            background-color: #f0f0f0;
            padding: 10px;
            position: sticky;
            bottom: 0;
            z-index: 2;
        }
        .search-form {
            display: flex;
            align-items: center;
        }

        .search-input {
            flex-grow: 1;
            border: none;
            height: 40px;
            border-radius: 5px;
            padding: 5px;
        }

        .search-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        
       .bubble {
            background-color: #007bff;
            color: #fff;
            border-radius: 25px;
            padding: 5px 10px;
            margin: 5px;
            text-align: left;
            display: inline-block; /* バブルをインラインブロック要素に設定 */
    max-width: 80%; /* バブルの最大幅を設定 */
    word-wrap: break-word; /* 長いテキストがはみ出さないように改行 */
        }

        /* タイトルスタイル */
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <a class="circle-back-button" href="/chatmemo">戻る</a>
            <p>重要度</p>
            <select class="select-menu" id="select-menu-1">
                <option value="yes">Yes</option>
                <option value="no">No</option>
                <option value="all">all</option>
            </select>
            <p>種類</p>
            <select class="select-menu" id="select-menu-2">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="all">all</option>
            </select>
            <p>付箋</p>
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->

@foreach($groupedData as $year => $yearData)
    <h2><div class="bubble">{{ $year }}</div></h2>
    <div class="year-container">
        @foreach($yearData as $monthYear => $monthYearData)
            <div class="month-container">
                <h3><div class="bubble">{{ $monthYear }}</div></h3>
                <ul>
                    @foreach($monthYearData as $day => $dayData)
                        <li class="right-align"><div class="bubble">{{ $day }}</div></li>
                                <ul>
                                    @foreach($dayData as $record)
                                        <li class="right-align">
                                             @if ($record)
                                                     @if ($record instanceof \App\Models\Think)
                                                <div class="bubble"><a href="/record/think/{{ $record->id }}">{{ $record->title }}</a></div>
                                            @elseif ($record instanceof \App\Models\Memo)
                                                <div class="bubble"><a href="/record/memo/{{ $record->id }}">{{ $record->title }}</a></div>
                                            @elseif ($record instanceof \App\Models\Todolist)
                                                <div class="bubble"><a href="/record/todolist/{{ $record->id }}">{{ $record->title }}</a></div>
                                            @elseif ($record instanceof \App\Models\Plan)
                                                <div class="bubble"><a href="/record/plan/{{ $record->id }}">{{ $record->title }}</a></div>
                                            @endif
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@endforeach
 {{ $pagedRecordDetails->links() }}
 
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
        </div>
        <div class="divider"></div>
        <div class="bottom">
            <form class="search-form">
                <input type="text" class="search-input" placeholder="検索...">
                <button type="submit" class="search-button">検索</button>
            </form>
    <script>
        const selectMenu1 = document.getElementById("select-menu-1");
        const selectMenu2 = document.getElementById("select-menu-2");
  
    </script>
</body>
</html>
