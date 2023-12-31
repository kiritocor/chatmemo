<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scrollable Middle Section</title>
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
            height: 40px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #ccc;
            position: sticky;
            top: 0;
            z-index: 2; /* 他の要素の上に表示 */
        }

        .circle-button {
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
            top: 10px;
            left: 10px;
        }
        
        .circle-yes-button {
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
            
            left: 10px;
        }
        
        .circle-no-button {
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

            left: 10px;
        }

        .circle-button:hover {
            background-color: #ddd;
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
            z-index: 2; /* 他の要素の上に表示 */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #input-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px;
            width: 100%;
        }

        #message-input {
            border: none;
            height: 40px;
            border-radius: 5px;
            padding: 5px;
            flex-grow: 1;
        }

        #send-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        #store-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        #store-button-container {
            display: none;
        }

        /* チャット関連のスタイル */
        #chat-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 60px); /* チャットエリアの高さを計算 */
            padding: 10px;
        }

        .message {
            display: flex;
            justify-content: flex-end; /* 右揃え */
            margin: 10px;
            cursor: pointer; /* メッセージをクリック可能にする */
        }

        .message.left {
            justify-content: flex-start; /* 左揃え */
        }

        .bubble {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px;
            padding: 10px;
            max-width: 70%; /* バブルの最大幅 */
        }

        .edit-input {
            border: none;
            border-radius: 5px;
            padding: 5px;
            width: 100%;
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
            <!-- 上部 -->
            <a class="circle-button" href="/qpage">戻る</a>
            <p>会話</p>
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->
            <div id="chat-container">
                <div class="message">
                    <div class="bubble">やるべきことは何ですか？</div>
                </div>
            </div>
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
        </div>
        <div class="divider"></div>
        <div class="bottom">
            <div id="input-container">
                <input type="text" id="message-input" placeholder="メッセージを入力...">
                <button id="confirm-button" style="display: none;">確定</button>
                <button id="send-button" style="display: none;">送信</button>
                <a id="circle-yes-button" style="display: none;">はい</a>
                <a id="circle-no-button" style="display: none;">いいえ</a>
    <label for="year" style="display: none;">年:</label>
    <select name="year" id="year" style="display: none;"></select>

    <label for="month" style="display: none;">月:</label>
    <select name="month" id="month" style="display: none;"></select>

    <label for="day" style="display: none;">日:</label>
    <select name="day" id="day" style="display: none;"></select>

    <label for="hour" style="display: none;">時:</label>
    <select name="hour" id="hour" style="display: none;"></select>

    <label for="minute" style="display: none;">分:</label>
    <select name="minute" id="minute" style="display: none;"></select>
    
    <button type="submit" id="savedate" style="display: none;">日時を保存</button>
            </div>
        </div>
    </div>
<script>
document.addEventListener("DOMContentLoaded", function () {
        const chatContainer = document.getElementById("chat-container");
        const messageInput = document.getElementById("message-input");
        const confirmButton = document.getElementById("confirm-button");
        const circleyesbutton = document.getElementById("circle-yes-button");
        const circlenobutton = document.getElementById("circle-no-button");
        const sendButton = document.getElementById("send-button");
        const fixedMessages = [
            "リンクはある？",
            "具体的には？",
            "重要なやるべきこと？それともいつかやりたいこと？",
            "そのことに対してどう思っている?",
            "いつまでにやっておきたい？",
            "ありがとう！忘れないように記録しました。"
        ];
        let selectedMessage = [];

        let leftMessages = [];
        let currentIndex = 0;
        let inputFormHidden = false;
        let pendingMessages = []; // 
        let editMode = false; // 編集モードのフラグ
        let messageText = messageInput.value.trim();
        
         // 年の選択肢を作成
        const yearSelect = document.getElementById("year");
        const currentYear = new Date().getFullYear();
        for (let year = currentYear; year <= currentYear + 10; year++) {
            const option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }

        // 月の選択肢を作成
        const monthSelect = document.getElementById("month");
        for (let month = 1; month <= 12; month++) {
            const option = document.createElement("option");
            option.value = month;
            option.textContent = month;
            monthSelect.appendChild(option);
        }

        // 日の選択肢を作成（月によって変動）
        const daySelect = document.getElementById("day");
        monthSelect.addEventListener("change", updateDays);

        // 時の選択肢を作成
        const hourSelect = document.getElementById("hour");
        for (let hour = 0; hour < 24; hour++) {
            const option = document.createElement("option");
            option.value = hour;
            option.textContent = hour;
            hourSelect.appendChild(option);
        }

        // 分の選択肢を作成
        const minuteSelect = document.getElementById("minute");
        for (let minute = 0; minute < 60; minute++) {
            const option = document.createElement("option");
            option.value = minute;
            option.textContent = minute;
            minuteSelect.appendChild(option);
        }

        // 初期化
        updateDays();

        function updateDays() {
            const selectedYear = parseInt(yearSelect.value);
            const selectedMonth = parseInt(monthSelect.value);
            const lastDay = new Date(selectedYear, selectedMonth, 0).getDate();

            daySelect.innerHTML = "";
            for (let day = 1; day <= lastDay; day++) {
                const option = document.createElement("option");
                option.value = day;
                option.textContent = day;
                daySelect.appendChild(option);
            }
        }

        // メッセージ送信時の処理
function sendMessage() {
messageText = messageInput.value.trim();
    if (messageText === "") return;
    console.log(pendingMessages.length)

    // ユーザーの左揃えメッセージを表示
    const messageDiv = document.createElement("div");
    messageDiv.classList.add("message", "left");
    messageDiv.innerHTML = `<div class="bubble">${messageText}</div>`;
    chatContainer.appendChild(messageDiv);

    // メッセージを配列に追加
    pendingMessages.push(messageText);

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // メッセージ入力後に右揃えのメッセージを表示（必要であれば条件を追加）
    if (currentIndex < fixedMessages.length) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.innerHTML = `<div class="bubble">${fixedMessages[currentIndex]}</div>`;
        chatContainer.appendChild(messageDiv);
        currentIndex++;
    }

if (pendingMessages.length === 3 ){
    // メッセージフィールドを非表示にする
    messageInput.style.display = "none";

    // はい・いいえのボタンを表示する
     circleyesbutton.style.display = "block";
     circlenobutton.style.display = "block";
}

if (pendingMessages.length === 5 ){
    // メッセージフィールドを非表示にする
    messageInput.style.display = "none";

    // ボタンを表示する
    document.querySelectorAll("label, select, button#savedate").forEach(element => {
            element.style.display = "block";
        });
     //circlenobutton.style.display = "block";
}

    // 左揃えのメッセージが６回入力されたら確定ボタンを表示
if (pendingMessages.length >= 4 && !inputFormHidden) {
        confirmButton.style.display = "block";
        messageInput.style.display = "none"; // メッセージ入力フォームを非表示に
        editMode = true; // 編集モードを有効に
    }

    messageInput.value = "";
}

savedate.addEventListener("click", function () {
// プルダウンメニューから選択された値を取得
const selectedYear = yearSelect.value;
const selectedMonth = monthSelect.value;
const selectedDay = daySelect.value;
const selectedHour = hourSelect.value;
const selectedMinute = minuteSelect.value;

// 選択された年月日から日付文字列を生成
const formattedDate = `${selectedYear}年${selectedMonth}月${selectedDay}日${selectedHour}時${selectedMinute}分`;

// メッセージに表示するテキストとして設定
const messageText = formattedDate;

    messageInput.style.display = "block";
    
    document.querySelectorAll("label").forEach(element => {
            element.style.display = "none";
        });
    yearSelect.style.display = "none"
    monthSelect.style.display = "none"
    daySelect.style.display = "none"
    hourSelect.style.display = "none"
    minuteSelect.style.display = "none"
    savedate.style.display = "none"
    circlenobutton.style.display = "none"
    
    const messageDiv = document.createElement("div");
    messageDiv.classList.add("message", "left");
    messageDiv.innerHTML = `<div class="bubble">${messageText}</div>`;
    chatContainer.appendChild(messageDiv);

    // メッセージを配列に追加
    pendingMessages.push(messageText);

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // メッセージ入力後に右揃えのメッセージを表示（必要であれば条件を追加）
    if (currentIndex < fixedMessages.length) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.innerHTML = `<div class="bubble">${fixedMessages[currentIndex]}</div>`;
        chatContainer.appendChild(messageDiv);
        currentIndex++;
                sendMessage();
    }

    });

 circleyesbutton.addEventListener("click", function () {
        // はいボタンがクリックされた場合の処理
        // ここで「はい」の入力を受け付ける処理を追加
        // ボタンを非表示にし、メッセージフィールドを表示する
        const selectedMessage = 'はい'; // 選択されたメッセージ
    messageText = selectedMessage;
        
    circleyesbutton.style.display = "none"
    circlenobutton.style.display = "none"
    messageInput.style.display = "block";
    
    const messageDiv = document.createElement("div");
    messageDiv.classList.add("message", "left");
    messageDiv.innerHTML = `<div class="bubble">${messageText}</div>`;
    chatContainer.appendChild(messageDiv);

    // メッセージを配列に追加
    pendingMessages.push(messageText);

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // メッセージ入力後に右揃えのメッセージを表示（必要であれば条件を追加）
    if (currentIndex < fixedMessages.length) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.innerHTML = `<div class="bubble">${fixedMessages[currentIndex]}</div>`;
        chatContainer.appendChild(messageDiv);
        currentIndex++;
                sendMessage();
    }

    });

circlenobutton.addEventListener("click", function () {
        // いいえボタンがクリックされた場合の処理
        // ここで「いいえ」の入力を受け付ける処理を追加
        // ボタンを非表示にし、メッセージフィールドを表示する
         const selectedMessage = 'いいえ'; // 選択されたメッセージ
    messageText = selectedMessage;
        
        circleyesbutton.style.display = "none"
        circlenobutton.style.display = "none"
        messageInput.style.display = "block";
        
        if (pendingMessages.length === 4 ){
        document.querySelectorAll("label, select").forEach(element => {
            element.style.display = "none";
        });
        savedate.style.display = "none"
        }
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message", "left");
    messageDiv.innerHTML = `<div class="bubble">${messageText}</div>`;
    chatContainer.appendChild(messageDiv);

    // メッセージを配列に追加
    pendingMessages.push(messageText);

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // メッセージ入力後に右揃えのメッセージを表示（必要であれば条件を追加）
    if (currentIndex < fixedMessages.length) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.innerHTML = `<div class="bubble">${fixedMessages[currentIndex]}</div>`;
        chatContainer.appendChild(messageDiv);
        currentIndex++;
sendMessage();
    }
    });

// メッセージクリックイベントを設定
        chatContainer.addEventListener("click", function (e) {
        
            if (editMode) { // 編集モードの場合のみ編集可能
               const messageDiv = e.target.closest(".message");
                confirmButton.style.display = "block";
                sendButton.style.display = "none";
                
                if (messageDiv && messageDiv.classList.contains("left")) {
                    const bubbleDiv = messageDiv.querySelector(".bubble");
                    const messageText = bubbleDiv.textContent;
                    
                    const originalMessageIndex = pendingMessages.indexOf(messageText);
                    
                    editMessage(messageDiv, messageText, originalMessageIndex);
                    
    　　}
    }
});


        // メッセージクリック時の処理
        function editMessage(messageDiv, messageText, originalMessageIndex) {
            editMode = false
            const bubbleDiv = messageDiv.querySelector(".bubble");
            bubbleDiv.innerHTML = `<input class="edit-input" type="text" value="${messageText}" />`;
            const editInput = bubbleDiv.querySelector(".edit-input");
            editInput.focus();
            editInput.addEventListener("keydown", function (e) {
                if (e.key === "Enter") {
                editMode = true
                    const editedText = editInput.value.trim();
                    if (editedText !== "") {
                        bubbleDiv.innerHTML = editedText;
                        
                        // 編集が確定されたときの処理
            confirmButton.addEventListener("click", function () {
                if (editMode) {
                    const editedText = bubbleDiv.textContent.trim();
                    if (editedText !== "") {
                        // 編集後のメッセージを対応する項目に格納
                        pendingMessages[originalMessageIndex] = editedText;
                        
                        // 確定ボタンを非表示にし、送信ボタンを表示
                        confirmButton.style.display = "none";
                        sendButton.style.display = "block";
                }
            }
        });
                    }
                }
            });
        }
        
        // 確定ボタンクリック時の処理
        confirmButton.addEventListener("click", function () {
            if (editMode) { // 編集モードの場合のみ確定処理を実行

                // 確定ボタンを非表示にし、送信ボタンを表示
                confirmButton.style.display = "none";
                sendButton.style.display = "block";
                }   
            }
        );


        // 送信ボタンクリック時の処理
        sendButton.addEventListener("click", function () {
    
    
const answers = {};
    
     for (let i = 0; i < pendingMessages.length; i++) {
            answers[`question${i + 1}`] = pendingMessages[i];
        }   

        // サーバーにデータを送信
        sendMessageToServer(answers, true)
        
    
});

        // テキストボックスでEnterキーを押したときの処理
        messageInput.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                sendMessage();
            }
        });

        // Ajaxリクエストを送信
        function sendMessageToServer(answers) {

            if (editMode) { // 編集モードの場合のみ送信処理を実行
    
                    // LaravelのCSRFトークンを取得
                    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

                    // Ajaxリクエストを送信
                    fetch('/save-todo-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(answers),
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('メッセージの送信中にエラーが発生しました。');
                }
            })
            .then(data => {
                // メッセージが送信された後の処理を行う
                alert("メッセージが保存されました。");

                // リダイレクト
                window.location.href = "/chatmemo";
            })
            .catch(error => {
                alert(error.message);
            });

                    
                
            }
        }
        });
    </script>
    
</body>
</html>