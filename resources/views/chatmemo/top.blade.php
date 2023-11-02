<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top</title>
    <style>
    /* サイドメニューバーのスタイル */
        .side-menu {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #f0f0f0;
            padding-top: 60px;
        }

        .menu-list-item {
            padding: 30px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .menu-list-item:hover {
            color: black;
        }

        /* コンテンツエリアのスタイル */
        .content {
            margin-left: 250px; /* サイドメニューの幅と合わせる */
            padding: 0px;
        }
        /* カレンダーのスタイル */
        .calendar {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            font-size: 18px; /* フォントサイズを大きくする */
        }

        table th, table td {
            text-align: center;
            padding: 10px; /* セルの内側の余白を調整 */
            position: relative; /* 相対位置指定 */
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            cursor: pointer;
        }
        
        /* メモ表示用のスタイル */
        .memo-dialog {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 1; /* ダイアログを前面に表示 */
        }
    
        /* 全体のコンテナ */
        .container {
            display: flex;
            flex-direction: column;
            height: 200vh; /* 画面の高さいっぱいに表示 */
        }

        /* 上部セクション */
        .top {
            background-color: #f0f0f0;
            padding: 10px;
            position: sticky;
            top: 0;
            z-index: 3; /* 他の要素の上に表示 */
        }

          /* 区切り線スタイル */
        .divider {
            border-top: 1px solid #ccc;
            margin: 0px 0;
        }

        /* 中央セクション */
        .middle {
            flex-grow: 1; /* 空きスペースを埋める */
             /*overflow-y: scroll;  縦スクロールを有効にする */
            padding: 10px;
            display: flex;
            flex-direction: row;
            flex: 3;
            display: flex;
            justify-content: space-between;
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
        
        .bubble {
            background-color: #f0f0f0;
            color: black;
            border-radius: 25px;
            padding: 5px 10px;
            margin: 5px;
            text-align: left;
            display: inline-block; /* バブルをインラインブロック要素に設定 */
    max-width: 80%; /* バブルの最大幅を設定 */
    word-wrap: break-word; /* 長いテキストがはみ出さないように改行 */
        }
        
        .sorve-button {
            background-color: #f0f0f0;
            color: black;
            border-radius: 25px;
            padding: 5px 10px;
            margin: 5px;
            text-align: left;
            display: inline-block; /* バブルをインラインブロック要素に設定 */
    max-width: 80%; /* バブルの最大幅を設定 */
    word-wrap: break-word; /* 長いテキストがはみ出さないように改行 */
        }
        
        .unsorve-button {
            background-color: #f0f0f0;
            color: black;
            border-radius: 25px;
            padding: 5px 10px;
            margin: 5px;
            text-align: left;
            display: inline-block; /* バブルをインラインブロック要素に設定 */
    max-width: 80%; /* バブルの最大幅を設定 */
    word-wrap: break-word; /* 長いテキストがはみ出さないように改行 */
        }
        
        .bubble:hover {
            transform: scale(1.2);
        }
        
        .sorve-button:hover {
            transform: scale(1.2);
        }
        
        .unsorve-button:hover {
            transform: scale(1.2);
        }
        
        .title-bubble {
            background-color: #f0f0f0;
            color: black;
            border-radius: 25px;
            padding: 5px 10px;
            margin: 5px;
            text-align: left;
            display: inline-block; /* バブルをインラインブロック要素に設定 */
    max-width: 80%; /* バブルの最大幅を設定 */
    word-wrap: break-word; /* 長いテキストがはみ出さないように改行 */
        }
        
        .title-bubble:hover {
            transform: scale(1.2);
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
        .rectangle-accordion-left {
            
            display: flex;
            flex-direction: column;
            width: 300px;
            flex: 1;
        }
        
        .rectangle-accordion-right {
            display: flex;
            flex-direction: column;
            width: 300px;
            flex: 1;
        }
        
        .rectangle-accordion-calendar {
            display: flex;
            flex-direction: column;
            width: 300px;
            flex: 1;
        }

        .accordion-item {
            display: flex;
            flex-direction: column;
            align-items: left;
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
            background-color: white;
            color: #333;
            border-radius: 10px; /* 角を丸くする */
            z-index: 1;
            text-align: left; /* テキストを左寄せにする */
        }
        .selectsorve {
            width: 300px;
            padding: 10px;
            background-color: gray;
            color: black;
            border-radius: 10px; /* 角を丸くする */
            z-index: 1;
            text-align: left; /* テキストを左寄せにする */
        }
        
        .plan {
            display: flex;
            flex-direction: column;
            color: black;
        }
        
        .plan-title {
            display: flex;
            flex-direction: row;
        }
        
        .plan-text {
            display: none;
        }
        
        .plan-title.active .plan-text {
            display: block;
            margin-top: 10px; /* テキストが表示される際にタイトルとの間に余白を追加 */
        }
        
        .todo {
            display: flex;
            flex-direction: column;
            color: black;
        }
        
        .left {
            flex: 1;
        }

        .right {
            flex: 1;
        }

        .accordion-title:hover {
            transform: scale(1.2);
        }

        .accordion-item.active .accordion-text {
            display: block;
            margin-top: 10px; /* テキストが表示される際にタイトルとの間に余白を追加 */
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>
    <!-- サイドメニューバー -->
    <div class="side-menu">
        <ul class="menu-list">
            <div class="menu-list-item">直近のメモ</div>
            <div class="menu-list-item">未解決の予定</div>
            <div class="menu-list-item">カレンダー</div>
            <a class="menu-list-item" href="/qpage">会話</a>
            <a class="menu-list-item" href="/record">記録</a>
            <!-- 必要なメニュー項目を追加 -->
       
        </ul>
    </div>
    <div class="content">
    <div class="container">
        <div class="top">
            <!-- 現在の年、月、日、曜日を表示 -->
            <p id="date"></p>
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->
            
            <div id="rectangle-accordion-left" class="rectangle-accordion-left">
                <h2>直近のメモ・出来事・考えたこと</h2>
                <div class="accordion-item">
                    <div class="accordion-title">直近のメモ</div>
                    <div class="accordion-text">
                        @foreach($groupedData as $year => $yearData)
        <div class="year-container">
            <h2><div class="yearbubble">{{ $year }}</div></h2>
            @foreach($yearData as $monthYear => $monthYearData)
                <div class="month-container">
                    <h3><div class="monthbubble">{{ $monthYear }}</div></h3>
                    @foreach($monthYearData as $day => $dayData)
                        <div class="day-container">
                            <h4><div class="daybubble">{{ $day }}</div></h4>
                            <ul>
                                @foreach($dayData as $record)
                                    <li class="right-align">
                                        @if ($record instanceof \App\Models\Think)
                                            <div class="bubble"><a href="/record/think/{{ $record->id }}">{{ $record->title }}</a></div>
                                        @elseif ($record instanceof \App\Models\Memo)
                                            <div class="bubble"><a href="/record/memo/{{ $record->id }}">{{ $record->title }}</a></div>
                                        @elseif ($record instanceof \App\Models\Todolist)
                                            <div class="bubble"><a href="/record/todo/{{ $record->id }}">{{ $record->title }}</a></div>
                                        @elseif ($record instanceof \App\Models\Plan)
                                            <div class="bubble"><a href="/record/plan/{{ $record->id }}">{{ $record->title }}</a></div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
        </div>
            </div>
            
    <div class="accordion-item">
        <div class="accordion-title">出来事</div>
        
        <div class="accordion-text">
            
            @foreach($sortedplanData as $planyear => $planyearData)
        <div class="year-container">
            <h2><div class="yearbubble">{{ $planyear }}</div></h2>
            @foreach($planyearData as $planmonthYear => $planmonthYearData)
                <div class="month-container">
                    <h3><div class="monthbubble">{{ $planmonthYear }}</div></h3>
                    @foreach($planmonthYearData as $planday => $plandayData)
                        <div class="day-container">
                            <h4><div class="daybubble">{{ $planday }}</div></h4>
                            <ul>
                                @foreach($plandayData as $planrecord)
                                    <li class="right-align">
                                            <div class="bubble"><a href="/record/memo/{{ $planrecord->id }}">{{ $planrecord->title }}</a></div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach
            </div>
            @endforeach
            
            </div>
            
            </div>
                
                <div class="accordion-item">
                    <div class="accordion-title">考えたこと</div>
                    <div class="accordion-text">
                         @foreach($sortedtodoData as $todoyear => $todoyearData)
        <div class="year-container">
            <h2><div class="yearbubble">{{ $todoyear }}</div></h2>
            @foreach($todoyearData as $todomonthYear => $todomonthYearData)
                <div class="month-container">
                    <h3><div class="monthbubble">{{ $todomonthYear }}</div></h3>
                    @foreach($todomonthYearData as $tododay => $tododayData)
                        <div class="day-container">
                            <h4><div class="daybubble">{{ $tododay }}</div></h4>
                            <ul>
                                @foreach($tododayData as $todorecord)
                                    <li class="right-align">
                                            <div class="bubble"><a href="/record/think/{{ $todorecord->id }}">{{ $todorecord->title }}</a></div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach
            </div>
            @endforeach
            
                    </div>
                </div>
            </div> 
            <div id="rectangle-accordion-right" class="rectangle-accordion-right">
                <h2>予定・やるべきこと</h2>
                <div class="select-sorve" id="selectsolve">
                    <div class="bubble" id="unsorvechange">未解決</div>
                        <div class="bubble" id="sorvechange">解決</div>
                </div>
                <div class="plan-text-columm" id="plancontainer">
                    <div id="togglecontainer">
                        <div class="plan" id="plan">
                        予定
                            <ul>
                                @foreach($sortedwhenplanData as $whenplanData)
                                    <li class="right-align">
                                        <div class="plan-title">
                                            <div class="title-bubble">{{ $whenplanData->title }}</div>
                                        <div class="plan-text">
                                            <div class="bubble"><a href="/record/plan/{{ $whenplanData->id }}">詳細</a></div>
                                            <div class="sorve-button" tag-id="3" data-record-id="{{ $whenplanData->id }}">解決！</div>
                                        </div>
                                        </div>
                                            <div class="bubble">{{ date('Y年n月j日G時i分', strtotime($whenplanData->when_plan)) }}までに</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="todo" id="todo">
                        やるべきこと
                        <ul>
                                @foreach($sortedwhentodoData as $whentodoData)
                                    <li class="right-align">
                                        <div class="plan-title">
                                            <div class="title-bubble">{{ $whentodoData->title }}</div>
                                        <div class="plan-text">
                                            <div class="bubble"><a href="/record/todo/{{ $whentodoData->id }}">詳細</a></div>
                                            <div class="sorve-button" tag-id="2" data-record-id="{{ $whentodoData->id }}">解決！</div>
                                        </div>
                                        </div>
                                            <div class="bubble">{{ date('Y年n月j日G時i分', strtotime($whentodoData->when_todo)) }}までに</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                </div>
                </div>
            </div>
            <div class="retangle-accordion-calendar">
            <div class="calendar">
        <h2>カレンダー</h2>
        <h3 id="calenderoptions"></h3>
        <table id="calendarTable">
            <thead>
                <tr>
                    <th>日</th>
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th>土</th>
                </tr>
            </thead>
            <tbody>
                <!-- カレンダーの日付セルはここに生成されます -->
            </tbody>
        </table>
    </div>
    </div>
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
    <!--    </div>-->
    <!--    <div class="divider"></div>-->
    <!--    <div class="bottom">-->
            <!-- 左側のボタン -->
    <!--        <a button class="circle-button" href="/qpage">会話</a>-->
    <!--        </button>-->
            <!-- 右側のボタン -->
    <!--        <a button class="circle-button" href="/record">記録</a>-->
    <!--        </button>-->
    <!--    </div>-->
    <!--</div>-->
    <!--</div>-->
    
    <!-- JavaScriptで現在の年、月、日、曜日を表示 -->
    <script>
    // カレンダーを生成する関数
        function generateCalendar(year, month) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);

            const tableBody = document.querySelector("#calendarTable tbody");
            tableBody.innerHTML = "";

            let date = new Date(firstDay);
            while (date <= lastDay) {
                const newRow = document.createElement("tr");

                for (let i = 0; i < 7; i++) {
                    if (date.getDay() === i) {
                        const newCell = document.createElement("td");
                        newCell.textContent = date.getDate();
                        newCell.addEventListener("click", (event) => {
                            // クリック時にメモを表示するダイアログを表示
                            const memoDialog = document.createElement("div");
                            memoDialog.className = "memo-dialog";
                            memoDialog.textContent = "ここにメモを表示";

                            // ダイアログを閉じるボタンを追加
                            const closeButton = document.createElement("button");
                            closeButton.textContent = "閉じる";
                            closeButton.addEventListener("click", () => {
                                memoDialog.style.display = "none";
                            });
                            memoDialog.appendChild(closeButton);

                            // カレンダーセルの位置にダイアログを配置
                            const cellRect = newCell.getBoundingClientRect();
                            memoDialog.style.left = cellRect.left + "px";
                            memoDialog.style.top = cellRect.bottom + "px";

                            document.body.appendChild(memoDialog);
                        });
                        newRow.appendChild(newCell);

                        date.setDate(date.getDate() + 1);
                    } else {
                        const newCell = document.createElement("td");
                        newRow.appendChild(newCell);
                    }
                }

                tableBody.appendChild(newRow);
            }
        }

        // カレンダーを初期表示
        const currentDate = new Date();
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        
        const dateElement = document.getElementById('date');
        
        const calenderElement = document.getElementById('calenderoptions');
    
        const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
        const calenderoptions = { year: 'numeric', month: 'long' };
        dateElement.textContent = currentDate.toLocaleDateString('ja-US', options);
        calenderElement.textContent = currentDate.toLocaleDateString('ja-US', calenderoptions);

     // JavaScriptでクリックで展開/折りたたむ動作を実装
        
    const rectangleaccordionleft = document.getElementById('rectangle-accordion-left');

rectangleaccordionleft.addEventListener('click', (e) => {
    const target = e.target;
    
    // 年、月、日の吹き出し（bubble）をクリックした場合
    if (target.classList.contains('accordion-title')) {
        target.parentElement.classList.toggle('active'); // クリックした吹き出しの状態を切り替える
    }
});

const rectangleaccordionright = document.getElementById('rectangle-accordion-right');

rectangleaccordionright.addEventListener('click', (e) => {
    const target = e.target;
    
    // 年、月、日の吹き出し（bubble）をクリックした場合
    if (target.classList.contains('title-bubble')) {
        target.parentElement.classList.toggle('active'); // クリックした吹き出しの状態を切り替える
    }
});

const Plancontainer = document.getElementById('plancontainer');

Plancontainer.addEventListener('click', (e) => {
    const target = e.target;
    
    // 年、月、日の吹き出し（bubble）をクリックした場合
    if (target.classList.contains('accordion-title')) {
        target.parentElement.classList.toggle('active'); // クリックした吹き出しの状態を切り替える
    }
});

// 解決ボタンがクリックされたときの処理
    document.querySelectorAll('.sorve-button').forEach(function(element) {
    element.addEventListener('click', function() {
        var recordId = this.getAttribute('data-record-id');
        var tagId = this.getAttribute('tag-id');

        // Ajaxリクエストを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/updateSorve', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // CSRFトークンを設定 (Laravelの場合)
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // データが正常に更新された場合の処理
                    // ここでUIを更新するなどの処理を行うことができます
                    alert("解決！");
                }
            } else {
                // エラー時の処理
            }
        };

        // データを送信
        var formData = new FormData();
        formData.append('recordId', recordId);
        formData.append('tagId', tagId);
        xhr.send(formData);
    });
});

// 未解決ボタンがクリックされたときの処理
    document.querySelectorAll('.unsorve-button').forEach(function(element) {
    element.addEventListener('click', function() {
        var recordId = this.getAttribute('data-record-id');
        var tagId = this.getAttribute('tag-id');

        // Ajaxリクエストを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/updateunSorve', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // CSRFトークンを設定 (Laravelの場合)
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // データが正常に更新された場合の処理
                    // ここでUIを更新するなどの処理を行うことができます
                    alert("未解決！");
                }
            } else {
                // エラー時の処理
            }
        };

        // データを送信
        var formData = new FormData();
        formData.append('recordId', recordId);
        formData.append('tagId', tagId);
        xhr.send(formData);
    });
});

document.getElementById('unsorvechange').addEventListener('click', function () {

        // Ajax リクエストを送信
       fetch('/filter-by-unsorve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            }) // データを取得するエンドポイントを指定
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(newData => {
            renderData(newData); // データを描画する関数を呼び出す
        })
        .catch(error => {
            console.error('Error:', error);
        });
        });
        
        // 新しいデータを表示エリアに描画する関数
function renderData(newData){
    // プランデータを描画
    var planContainer = document.getElementById('plan');

    var planHtml = '';
    
    planHtml += '<div class="plan">'
    planHtml += '予定';
    planHtml += '<ul>';
    newData.sortedwhenplanData.forEach(function(planData) {
     var formattedWhenPlan = planData.formatted_when_plan;
    
    planHtml += '<li class="right-align">';
    planHtml += '<div class="plan-title">';
    planHtml += '<div class="title-bubble">' + planData.title + '</div>';
    planHtml += '<div class="plan-text">';
    planHtml += '<div class="bubble"><a href="/record/plan/' + planData.id + '">詳細</a></div>';
    planHtml += '<div class="sorve-button" tag-id="3" data-record-id="' + planData.id + '">解決！</div>';
    planHtml += '</div>';
    planHtml += '</div>';
    planHtml += '<div class="bubble">' + formattedWhenPlan + 'までに</div>';
    planHtml += '</li>';
    });
    planHtml += '</ul>';
    planHtml += '</div>';
    planContainer.innerHTML = planHtml;

    // やるべきことデータを描画（同様の方法で行えます）
    // 以下に追加のコードを記述してください
    
    // プランデータを描画
    var todoContainer = document.getElementById('todo');

    var todoHtml = '';
    
    todoHtml += '<div class="todo">'
    todoHtml += '<p>やること</p>';
    todoHtml += '<ul>';
    newData.sortedwhentodoData.forEach(function(todoData) {
    var formattedWhenTodo = todoData.formatted_when_todo;
    
    todoHtml += '<li class="right-align">';
    todoHtml += '<div class="plan-title">';
    todoHtml += '<div class="title-bubble">' + todoData.title + '</div>';
    todoHtml += '<div class="plan-text">';
    todoHtml += '<div class="bubble"><a href="/record/todo/' + todoData.id + '">詳細</a></div>';
    todoHtml += '<div class="sorve-button" tag-id="2" data-record-id="' + todoData.id + '">解決！</div>';
    todoHtml += '</div>';
    todoHtml += '</div>';
    todoHtml += '<div class="bubble">' + formattedWhenTodo + 'までに</div>';
    todoHtml += '</li>';
    });
    todoHtml += '</ul>';
    todoHtml += '</div>';
    todoContainer.innerHTML = todoHtml;
    
    // 解決ボタンがクリックされたときの処理
    document.querySelectorAll('.sorve-button').forEach(function(element) {
    element.addEventListener('click', function() {
        var recordId = this.getAttribute('data-record-id');
        var tagId = this.getAttribute('tag-id');

        // Ajaxリクエストを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/updateSorve', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // CSRFトークンを設定 (Laravelの場合)
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // データが正常に更新された場合の処理
                    // ここでUIを更新するなどの処理を行うことができます
                    // データ更新後に新しいデータを取得し、描画する
                }
            } else {
                // エラー時の処理
            }
        };

        // データを送信
        var formData = new FormData();
        formData.append('recordId', recordId);
        formData.append('tagId', tagId);
        xhr.send(formData);
        
    });
});

    }
    
    
    document.getElementById('sorvechange').addEventListener('click', function () {

        // Ajax リクエストを送信
       fetch('/filter-by-sorve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            }) // データを取得するエンドポイントを指定
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
        sorveData(data)
        })
        .catch(error => {
            console.error('Error:', error);
        });
        });
        
        // データを表示エリアに描画する関数
function sorveData(data) {
    var planContainer = document.getElementById('plan');

    var planHtml = '';
    
     planHtml += '<div class="accordion-item">'
     planHtml += '<div class="accordion-title">予定</div>'
     planHtml += '<div class="accordion-text">'

    // データをループして描画
    for (var year in data.sortedplanData) {
        planHtml += '<div class="year-container">';
        planHtml += '<h2><div class="yearbubble">' + year + '</div></h2>';

        for (var monthYear in data.sortedplanData[year]) {
            planHtml += '<div class="month-container">';
            planHtml += '<h3><div class="monthbubble">' + monthYear + '</div></h3>';

            for (var day in data.sortedplanData[year][monthYear]) {
                planHtml += '<div class="day-container">';
                planHtml += '<h4><div class="daybubble">' + day + '</div></h4>';
                planHtml += '<ul>';

                data.sortedplanData[year][monthYear][day].forEach(function (record) {
                    planHtml += '<li class="right-align">';
                    planHtml += '<div class="plan-title">';
                    planHtml += '<div class="title-bubble">' + record.title + '</div>';
                    planHtml += '<div class="plan-text">';
                    planHtml += '<div class="bubble"><a href="/record/plan/' + record.id + '">詳細</a></div>';
                    planHtml += '<div class="unsorve-button" tag-id="3" data-record-id="' + record.id + '">未解決！</div>';
                    
                    
                    planHtml += '</div>';
                    planHtml += '</div>';
                    planHtml += '</li>';
                });

                planHtml += '</ul>';
                planHtml += '</div>';
            }

            planHtml += '</div>';
        }

        planHtml += '</div>';
    }
    planHtml += '</div>';
    planHtml += '</div>';

    planContainer.innerHTML = planHtml;
    
    
    var todoContainer = document.getElementById('todo');

    var todoHtml = '';
    
    todoHtml += '<div class="accordion-item">'
    todoHtml += '<div class="accordion-title">やること</div>'
    todoHtml += '<div class="accordion-text">'

    // データをループして描画
    for (var year in data.sortedtodoData) {
        todoHtml += '<div class="year-container">';
        todoHtml += '<h2><div class="yearbubble">' + year + '</div></h2>';

        for (var monthYear in data.sortedtodoData[year]) {
            todoHtml += '<div class="month-container">';
            todoHtml += '<h3><div class="monthbubble">' + monthYear + '</div></h3>';

            for (var day in data.sortedtodoData[year][monthYear]) {
                todoHtml += '<div class="day-container">';
                todoHtml += '<h4><div class="daybubble">' + day + '</div></h4>';
                todoHtml += '<ul>';

                data.sortedtodoData[year][monthYear][day].forEach(function (record) {
                    todoHtml += '<li class="right-align">';
                    todoHtml += '<div class="plan-title">';
                    todoHtml += '<div class="title-bubble">' + record.title + '</div>';
                    todoHtml += '<div class="plan-text">';
                    todoHtml += '<div class="bubble"><a href="/record/todo/' + record.id + '">詳細</a></div>';
                    todoHtml += '<div class="unsorve-button" tag-id="2" data-record-id="' + record.id + '">解決！</div>';
                    
                    
                    todoHtml += '</div>';
                    todoHtml += '</div>';
                    todoHtml += '</li>';
                });

                todoHtml += '</ul>';
                todoHtml += '</div>';
            }
            todoHtml += '</div>';
        }

        todoHtml += '</div>';
    }
    
    todoHtml += '</div>';
    todoHtml += '</div>';

    todoContainer.innerHTML = todoHtml;
    
    // 解決ボタンがクリックされたときの処理
    document.querySelectorAll('.unsorve-button').forEach(function(element) {
    element.addEventListener('click', function() {
        var recordId = this.getAttribute('data-record-id');
        var tagId = this.getAttribute('tag-id');

        // Ajaxリクエストを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/updateunSorve', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // CSRFトークンを設定 (Laravelの場合)
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // データが正常に更新された場合の処理
                    // ここでUIを更新するなどの処理を行うことができます
                    // データ更新後に新しいデータを取得し、描画する
                    
                }
            } else {
                // エラー時の処理
            }
        };

        // データを送信
        var formData = new FormData();
        formData.append('recordId', recordId);
        formData.append('tagId', tagId);
        xhr.send(formData);
        
        
    });
});
}


    </script>
</body>
</html>