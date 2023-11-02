<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scrolln</title>
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
            display: flex;
            flex-direction: row;
            flex: 2;
            justify-content: space-between;
        }
        
        .dataContainer {
            
            display: flex;
            flex-direction: column;
            width: 300px;
            flex: 1;
        }
        
        .dataContainer-right{
            top: 0;
            display: flex;
            flex-direction: column;
            width: 300px;
            flex: 1;
            z-index: 2;
            position: sticky;
            margin-right: 50px; /* 左寄りにするためのマージンを追加 */
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
        
       .yearbubble {
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
        
        .monthbubble {
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
        
        .daybubble {
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
        
        .tagpost-bubble {
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
        
        .maketagbubble {
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
        .bubble:hover {
            transform: scale(1.2);
        }
        
        .tagpost-bubble:hover {
            transform: scale(1.2);
        }

        /* タイトルスタイル */
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
        
        /*クリックで展開/折りたたむ動作を実装*/
        .yearbubble {
            cursor: pointer;
        }
        .yearbubble:hover {
            transform: scale(1.2);
        }
        .year-container.active .month-container {
            display: none;
        }
        .month-container {
            display: block;
        }
        
        
        /*クリックで展開/折りたたむ動作を実装*/
        .monthbubble {
            cursor: pointer;
        }
        .monthbubble:hover {
            transform: scale(1.2);
        }
        .month-container.active .day-container {
            display: none;
        }
        .day-container {
            display: block;
        }
        
        /*クリックで展開/折りたたむ動作を実装*/
        .daybubble {
            cursor: pointer;
        }
        .daybubble:hover {
            transform: scale(1.2);
        }
        .day-container.active .right-align {
            display: none;
        }
        .right-align {
            display: block;
        }
        
        a{
            text-decoration: none;
            color: black;
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
            width: 120px;
            display: none;
            padding: 20px;
            background-color: white;
            color: #333;
            border-radius: 10px; /* 角を丸くする */
            z-index: 1;
            text-align: left; /* テキストを左寄せにする */
        }
        .accordion-title:hover {
            transform: scale(1.2);
        }

        .accordion-item.active .accordion-text {
            display: block;
            margin-top: 10px; /* テキストが表示される際にタイトルとの間に余白を追加 */
        }
    </style>
</head>
<body>
    <!-- サイドメニューバー -->
    <div class="side-menu">
        
        <ul class="menu-list">
            <a class="circle-back-button" href="/chatmemo">戻る</a>
            <!-- 必要なメニュー項目を追加 -->
            <p>重要度</p>
            <select class="select-menu" id="importanceSelect">
                <option value="all">すべて</option>
                <option value="yes">重要</option>
                <option value="no">そこまで</option>
            </select>
            <p>種類</p>
            <select class="select-menu" id="categoryselect">
                <option value="memo">出来事</option>
                <option value="plan">予定</option>
                <option value="todo">やること/べきこと</option>
                <option value="think">考えたこと</option>
                <option value="all">すべて</option>
            </select>
       
        </ul>
    </div>
    <div class="content">
    <div class="container">
        
        <div class="top">
            
           <form class="search-form">
    <input type="text" class="search-input" id="search-input" placeholder="検索...">
    <div class="search-results" id="search-results"></div>
</form> 
            
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->
<div id="dataContainer" class="dataContainer">
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
                                            @if ($record)
                                            @if ($record instanceof \App\Models\Think)
                                                <div class="bubble" record-id="{{ $record->id }}"
                                                ondrop="drop(event, '{{ $record->id }}', '{{ $record->tag_id }}')"
                                                ondragover="allowDrop(event)"
                                                ><a href="/record/think/{{ $record->id }}">{{ $record->title }}</a></div>
                                                @foreach($record->tags as $tagPost)
                                                <div class="tagpost-bubble" tagpost-id="{{ $tagPost->pivot->id }}">{{ $tagPost->name }}</div>
                                                @endforeach
                                            @elseif ($record instanceof \App\Models\Memo)
                                                <div class="bubble" record-id="{{ $record->id }}"
                                                ondrop="drop(event, '{{ $record->id }}', '{{ $record->tag_id }}')"
                                                ondragover="allowDrop(event)"
                                                ><a href="/record/memo/{{ $record->id }}">{{ $record->title }}</a></div>
                                                @foreach($record->tags as $tagPost)
                                                <div class="tagpost-bubble" tagpost-id="{{ $tagPost->pivot->id }}">{{ $tagPost->name }}</div>
                                                @endforeach
                                            @elseif ($record instanceof \App\Models\Todolist)
                                                <div class="bubble" record-id="{{ $record->id }}"
                                                ondrop="drop(event, '{{ $record->id }}', '{{ $record->tag_id }}')"
                                                ondragover="allowDrop(event)">
                                                <a href="/record/todo/{{ $record->id }}">{{ $record->title }}</a></div>
                                                @foreach($record->tags as $tagPost)
                                                <div class="tagpost-bubble" tagpost-id="{{ $tagPost->pivot->id }}">{{ $tagPost->name }}</div>
                                                @endforeach
                                            @elseif ($record instanceof \App\Models\Plan)
                                                <div class="bubble" record-id="{{ $record->id }}"
                                                ondrop="drop(event, '{{ $record->id }}', '{{ $record->tag_id }}')"
                                                ondragover="allowDrop(event)">
                                                <a href="/record/plan/{{ $record->id }}">{{ $record->title }}</a></div>
                                                @foreach($record->tags as $tagPost)
                                                <div class="tagpost-bubble" tagpost-id="{{ $tagPost->pivot->id }}">{{ $tagPost->name }}</div>
                                                @endforeach
                                            @endif
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
<div id="dataContainer-right" class="dataContainer-right">
    <div class="accordion-item">
        <div class="accordion-title">作る</div>
        <div class="accordion-text">
            <div class="maketagbubble">名前を入力</div>
            <button id="send-button" >保存</button>
            </div>
            </div>
        <div class="accordion-item">
        <div class="accordion-title">選ぶ</div>
        <div class="accordion-text">
            @foreach($tagData as $tagrecord)
                <div class="bubble"　tag-record-id="{{ $tagrecord->id }}"
                draggable="true" ondragstart="dragStart(event, '{{ $tagrecord->id }}')"
                >{{ $tagrecord->name }}</div>
            @endforeach
            </div>
            </div>
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
        </div>
        </div>
        
</div>
</div>
    <script>
    
const sendButton = document.getElementById("send-button");

const DataContainerright = document.getElementById('dataContainer-right');
DataContainerright.addEventListener('click', (e) => {
    const target = e.target;
    
    // 年、月、日の吹き出し（bubble）をクリックした場合
    if (target.classList.contains('accordion-title')) {
        target.parentElement.classList.toggle('active'); // クリックした吹き出しの状態を切り替える
    }
});

  document.getElementById('importanceSelect').addEventListener('change', function () {
        const selectedImportance = this.value;

        // Ajax リクエストを送信
        fetch('/filter-by-importance', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ importance: selectedImportance })
        })
        .then(response => response.json())
        .then(data => {
        // 取得したデータを表示
        const dataContainer = document.getElementById('dataContainer');
        dataContainer.innerHTML = ''; // 既存のデータをクリア

        // 年ごとにデータを表示
        for (const year in data) {
            const yearData = data[year];
            const yearElement = document.createElement('div');
            yearElement.className = 'year-container';
            dataContainer.appendChild(yearElement);
            
            const yearmonthElement = document.createElement('h2');
            yearmonthElement.innerHTML = `<div class="yearbubble">${year}</div>`;
            yearElement.appendChild(yearmonthElement);

            // 月ごとにデータを表示
            for (const month in yearData) {
                const monthData = yearData[month];
                const monthElement = document.createElement('div');
                monthElement.className = 'month-container';
                yearElement.appendChild(monthElement);

                const monthYearElement = document.createElement('h3');
                monthYearElement.innerHTML = `<div class="monthbubble">${month}</div>`;
                monthElement.appendChild(monthYearElement);

                // 日ごとにデータを表示
                for (const day in monthData) {
                    const dayData = monthData[day];
                    const dayElement = document.createElement('div');
                　　dayElement.className = 'day-container';
                　　monthElement.appendChild(dayElement);
                    
                　　const daymonthElement = document.createElement('h4');
                　　daymonthElement.innerHTML = `<div class="daybubble">${day}</div>`;
                　　dayElement.appendChild(daymonthElement);
                
                　　const ulElement = document.createElement('ul');
                    daymonthElement.appendChild(ulElement);
                    
                    // レコードを表示
                    dayData.forEach(record => {
                        const recordElement = document.createElement('li');
                        recordElement.className = 'right-align';

                        // レコードの種類に応じてリンクを生成
                        if (record.think_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/think/${record.id}">${record.think_title}</a></div>`;
                        } else if (record.memo_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/memo/${record.id}">${record.memo_title}</a></div>`;
                        } else if (record.todo_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/todo/${record.id}">${record.todo_title}</a></div>`;
                        } else if (record.plan_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/plan/${record.id}">${record.plan_title}</a></div>`;
                        }

                        ulElement.appendChild(recordElement);
                        
                         

                    });
                }
            }
        }
    });
});

document.getElementById('categoryselect').addEventListener('change', function () {
        const selectedCategory = this.value;

        // Ajax リクエストを送信
        fetch('/filter-by-category', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ category: selectedCategory })
        })
        .then(response => response.json())
        .then(data => {
        // 取得したデータを表示
        const dataContainer = document.getElementById('dataContainer');
        dataContainer.innerHTML = ''; // 既存のデータをクリア

        // 年ごとにデータを表示
        for (const year in data) {
            const yearData = data[year];
            const yearElement = document.createElement('div');
            yearElement.className = 'year-container';
            dataContainer.appendChild(yearElement);
            
            const yearmonthElement = document.createElement('h2');
            yearmonthElement.innerHTML = `<div class="yearbubble">${year}</div>`;
            yearElement.appendChild(yearmonthElement);

            // 月ごとにデータを表示
            for (const month in yearData) {
                const monthData = yearData[month];
                const monthElement = document.createElement('div');
                monthElement.className = 'month-container';
                yearElement.appendChild(monthElement);

                const monthYearElement = document.createElement('h3');
                monthYearElement.innerHTML = `<div class="monthbubble">${month}</div>`;
                monthElement.appendChild(monthYearElement);

                // 日ごとにデータを表示
                for (const day in monthData) {
                    const dayData = monthData[day];
                    const dayElement = document.createElement('div');
                　　dayElement.className = 'day-container';
                　　monthElement.appendChild(dayElement);
                    
                　　const daymonthElement = document.createElement('h4');
                　　daymonthElement.innerHTML = `<div class="daybubble">${day}</div>`;
                　　dayElement.appendChild(daymonthElement);
                
                　　const ulElement = document.createElement('ul');
                    daymonthElement.appendChild(ulElement);
                    
                    // レコードを表示
                    dayData.forEach(record => {
                        const recordElement = document.createElement('li');
                        recordElement.className = 'right-align';

                        // レコードの種類に応じてリンクを生成
                        if (record.think_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/think/${record.id}">${record.think_title}</a></div>`;
                        } else if (record.memo_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/memo/${record.id}">${record.memo_title}</a></div>`;
                        } else if (record.todo_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/todo/${record.id}">${record.todo_title}</a></div>`;
                        } else if (record.plan_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/plan/${record.id}">${record.plan_title}</a></div>`;
                        }

                        ulElement.appendChild(recordElement);
                        
                         

                    });
                }
            }
        }
    });
});
    
    // JavaScriptでクリックで展開/折りたたむ動作を実装
const dataContainer = document.getElementById('dataContainer');

dataContainer.addEventListener('click', (e) => {
    const target = e.target;
    
    // 年、月、日の吹き出し（bubble）をクリックした場合
    if (target.classList.contains('yearbubble') || target.classList.contains('monthbubble') || target.classList.contains('daybubble')) {
        target.parentElement.parentElement.classList.toggle('active'); // クリックした吹き出しの状態を切り替える
    }
});



const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');

searchInput.addEventListener('input', () => {
    const searchQuery = searchInput.value;

    if (searchQuery.trim() === '') {
        searchResults.innerHTML = ''; // 入力が空の場合、予測結果をクリア
        return;
    }

    // サーバーへの非同期リクエストを送信
    fetch(`/search?query=${searchQuery}`)
        .then(response => response.json())
        .then(data => {
            // 取得したデータを表示
        const dataContainer = document.getElementById('dataContainer');
        dataContainer.innerHTML = ''; // 既存のデータをクリア

        // 年ごとにデータを表示
        for (const year in data) {
            const yearData = data[year];
            const yearElement = document.createElement('div');
            yearElement.className = 'year-container';
            dataContainer.appendChild(yearElement);
            
            const yearmonthElement = document.createElement('h2');
            yearmonthElement.innerHTML = `<div class="yearbubble">${year}</div>`;
            yearElement.appendChild(yearmonthElement);

            // 月ごとにデータを表示
            for (const month in yearData) {
                const monthData = yearData[month];
                const monthElement = document.createElement('div');
                monthElement.className = 'month-container';
                yearElement.appendChild(monthElement);

                const monthYearElement = document.createElement('h3');
                monthYearElement.innerHTML = `<div class="monthbubble">${month}</div>`;
                monthElement.appendChild(monthYearElement);

                // 日ごとにデータを表示
                for (const day in monthData) {
                    const dayData = monthData[day];
                    const dayElement = document.createElement('div');
                　　dayElement.className = 'day-container';
                　　monthElement.appendChild(dayElement);
                    
                　　const daymonthElement = document.createElement('h4');
                　　daymonthElement.innerHTML = `<div class="daybubble">${day}</div>`;
                　　dayElement.appendChild(daymonthElement);
                
                　　const ulElement = document.createElement('ul');
                    daymonthElement.appendChild(ulElement);
                    
                    // レコードを表示
                    dayData.forEach(record => {
                        const recordElement = document.createElement('li');
                        recordElement.className = 'right-align';

                        // レコードの種類に応じてリンクを生成
                        if (record.think_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/think/${record.id}">${record.think_title}</a></div>`;
                        } else if (record.memo_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/memo/${record.id}">${record.memo_title}</a></div>`;
                        } else if (record.todo_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/todo/${record.id}">${record.todo_title}</a></div>`;
                        } else if (record.plan_title) {
                            recordElement.innerHTML = `<div class="bubble"><a href="/record/plan/${record.id}">${record.plan_title}</a></div>`;
                        }

                        ulElement.appendChild(recordElement);
                        
                         

                    });
                }
            }
        }
        })
        .catch(error => {
            console.error('検索エラー:', error);
        });
});

if (DataContainerright && sendButton) {
    
DataContainerright.addEventListener("click", function (e) {

if (e.target.classList.contains("maketagbubble")) {

const messageDiv = e.target;
    const editInput = document.createElement("input");
            editInput.classList.add("edit-input");
            editInput.value = messageDiv.textContent;
            messageDiv.innerHTML = "";
            messageDiv.appendChild(editInput);
            editInput.focus();
            editInput.addEventListener("keydown", function (e) {
                if (e.key === "Enter") {
                    const editedText = editInput.value.trim();
                    messageDiv.innerHTML = editedText;
                }
            });
        }
    });
// 送信ボタンクリック時の処理
sendButton.addEventListener("click", function () {

 // 編集されたメッセージを格納するオブジェクト
        const editedMessages = [];

        // メッセージの要素を取得
        const messageDivs = DataContainerright.querySelectorAll(".maketagbubble");

        // メッセージごとに編集されたテキストを取得してオブジェクトに格納
        messageDivs.forEach((messageDiv) => {
            editedMessages.push(messageDiv.textContent);
        });
        // サーバーにメッセージを送信してアップデート
        sendMessageToServer(editedMessages);
        
    
});
}

function sendMessageToServer(editedMessages) {
    
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;


        // メッセージをサーバーに送信
        fetch(`/record/tag/save`, { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ messages: editedMessages }),
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('メッセージの送信中にエラーが発生しました。');
            }
        })
        .then(data => {
            alert("タグが保存されました。");

        })
        .catch(error => {
            alert(error.message);
        });
    }


var draggedTag = null;

function dragStart(event, tagId) {
    draggedTag = tagId;
}

function allowDrop(event) {
    event.preventDefault();
}

function drop(event, recordId, filterId) {
    event.preventDefault();
        if (draggedTag !== null) {
        var tagId = draggedTag;
        attachTagToPost(recordId, tagId, filterId);
    }
}

function attachTagToPost(recordId, tagId, filterId) {
    // サーバーサイドで中間テーブルにデータを保存するリクエストを送信
    fetch(`/attach-tag-to-post`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ recordId, tagId, filterId })
    })
    .then(response => response.json())
    .then(data => {
        // サーバーサイドからのレスポンスを処理
        if (data.success) {
            alert('タグが投稿に追加されました');
        } else {
            alert('タグの追加に失敗しました');
        }
    })
    .catch(error => {
        console.error('エラー:', error);
    });
}
     document.querySelectorAll('.tagpost-bubble').forEach(function(bubbleElement) {
    bubbleElement.addEventListener('click', function() {
    const tagPostId = bubbleElement.getAttribute('tagpost-id');
    
    // サーバーサイドにリクエストを送信
    fetch(`/delete-tagpost/${tagPostId}`, {
        method: 'DELETE', // または適切な HTTP メソッドを選択
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    })
    .then(response => response.json())
    .then(data => {
        // サーバーサイドからのレスポンスを処理
        if (data.success) {
            // 成功時の処理を追加
           bubbleElement.style.display = 'none'; // バブルを非表示
        } else {
            // 失敗時の処理を追加
            alert('削除に失敗しました');
        }
    })
    .catch(error => {
        console.error('エラー:', error);
    });
})
});



    </script>
</body>
</html>
