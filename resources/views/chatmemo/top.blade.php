<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top</title>
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
            background-color: #f0f0f0;
            padding: 10px;
            position: sticky;
            bottom: 0;
            z-index: 2; /* 他の要素の上に表示 */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 丸形のボタンスタイル */
        .circle-button {
            width: 80px;
            height: 80px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .circle-button:hover {
            background-color: #ddd;
        }
        /* 吹き出し設定 */
        .rectangle-accordion {
            display: flex;
            flex-direction: column;
            width: 300px;
        }

        .accordion-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
            cursor: pointer;
        }

        .accordion-title {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px; /* 角を丸くする */
            padding: 20px;
            width: 120px;
            text-align: center;
            line-height: 20px;
            transition: transform 0.3s;
            overflow: hidden;
        }

        .accordion-text {
            width: 300px;
            display: none;
            padding: 10px;
            background-color: greenyellow;
            color: #333;
            border-radius: 10px; /* 角を丸くする */
            z-index: 1;
            text-align: left; /* テキストを中央寄せにする */
        }

        .accordion-item:hover .accordion-title {
            transform: scale(1.2);
        }

        .accordion-item.active .accordion-text {
            display: block;
            margin-top: 10px; /* テキストが表示される際にタイトルとの間に余白を追加 */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <!-- 現在の年、月、日、曜日を表示 -->
            <p id="date"></p>
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->
            <div class="rectangle-accordion">
                <div class="accordion-item">
                    <div class="accordion-title">直近のメモ</div>
                    <div class="accordion-text">a</div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-title">予定</div>
                    <div class="accordion-text">b</div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-title">やること</div>
                    <div class="accordion-text">c</div>
                </div>
            </div>        
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
        </div>
        <div class="divider"></div>
        <div class="bottom">
            <!-- 左側のボタン -->
            <a button class="circle-button" href="/qpage">会話</a>
            </button>
            <!-- 右側のボタン -->
            <a button class="circle-button" href="/record">記録</a>
            </button>
        </div>
    </div>

    <!-- JavaScriptで現在の年、月、日、曜日を表示 -->
    <script>
        const dateElement = document.getElementById('date');
        const currentDate = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
        dateElement.textContent = currentDate.toLocaleDateString('ja-US', options);

     // JavaScriptでクリックで展開/折りたたむ動作を実装
     const accordionItems = document.querySelectorAll('.accordion-item');
        
        accordionItems.forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('active'); // クリックした吹き出しの状態を切り替える
            });
        });
    </script>
</body>
</html>