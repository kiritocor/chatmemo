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
    </style>
</head>
<body>
    <div class="container">
        
        <div class="top">
            <a class="circle-back-button" href="/chatmemo">戻る</a>
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
            <p>付箋</p>
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->
<div id="dataContainer">
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
                                                <div class="bubble"><a href="/record/think/{{ $record->id }}">{{ $record->title }}</a></div>
                                            @elseif ($record instanceof \App\Models\Memo)
                                                <div class="bubble"><a href="/record/memo/{{ $record->id }}">{{ $record->title }}</a></div>
                                            @elseif ($record instanceof \App\Models\Todolist)
                                                <div class="bubble"><a href="/record/todo/{{ $record->id }}">{{ $record->title }}</a></div>
                                            @elseif ($record instanceof \App\Models\Plan)
                                                <div class="bubble"><a href="/record/plan/{{ $record->id }}">{{ $record->title }}</a></div>
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
 
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
        </div>
        <div class="divider"></div>
        <div class="bottom">
            <form class="search-form">
    <input type="text" class="search-input" id="search-input" placeholder="検索...">
    <div class="search-results" id="search-results"></div>
</form>

    <script>
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

    </script>
</body>
</html>
