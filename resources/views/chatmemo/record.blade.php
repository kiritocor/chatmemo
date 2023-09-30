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

        /* 左から順に均等に分割 */
        .top > * {
            flex: 1;
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
            width: 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <a class="circle-back-button" href="chatmemo2.html">戻る</a>
            <select class="select-menu" id="select-menu-1">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <select class="select-menu" id="select-menu-2">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->
            @foreach($groupedPosts as $year => $yearPosts)
            <h2>{{ $year }}</h2>
            <div class="year-container">
                @foreach($yearPosts->groupBy(function ($post) {
                    return $post->date->format('F Y');
                }) as $monthYear => $monthYearPosts)
                    <div class="month-container">
                        <h3>{{ $monthYear }}</h3>
                        <ul>
                            @foreach($monthYearPosts->groupBy(function ($post) {
                                return $post->date->format('d日');
                            }) as $day => $dayPosts)
                                <li class="right-align">{{ $day }}</li>
                                <ul>
                                    @foreach($dayPosts as $post)
                                        <li class="right-align">{{ $post->title }}</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endforeach
        
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
        </div>
        <div class="divider"></div>
        <div class="bottom">
            <form class="search-form">
                <input type="text" class="search-input" placeholder="検索...">
                <button type="submit" class="search-button">検索</button>
            </form>
        </div>
    </div>


    <script>
        const selectMenu1 = document.getElementById("select-menu-1");
        const selectMenu2 = document.getElementById("select-menu-2");

        // セレクトメニュー1が変更されたときの処理
        selectMenu1.addEventListener("change", function () {
            const selectedValue = selectMenu1.value;
            alert(`セレクトメニュー1の選択: ${selectedValue}`);
        });

        // セレクトメニュー2が変更されたときの処理
        selectMenu2.addEventListener("change", function () {
            const selectedValue = selectMenu2.value;
            alert(`セレクトメニュー2の選択: ${selectedValue}`);
        });
    </script>
</body>
</html>
