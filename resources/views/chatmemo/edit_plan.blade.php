<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scrollable Middle Section</title>
    <style>
        /* 既存のスタイルコード（上部セクション、全体のコンテナ） */
        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

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
            z-index: 2;
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
            justify-content: flex-end;
            cursor: pointer;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .circle-button:hover {
            background-color: #ddd;
        }
        .edit-button {
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
            position: absolute;
        }

        .rightcircle-button:hover {
            background-color: #ddd;
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
            
            left: 50px;
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

            left: 70px;
        }
        .circle-cancel-button {
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

            left: 70px;
        }
        
        .divider {
            border-top: 1px solid #ccc;
            margin: 0px 0;
        }

        .middle {
            flex-grow: 1;
            overflow-y: scroll;
            padding: 10px;
        }

        /* メッセージのスタイル */
        .message {
            display: flex;
            justify-content: flex-end;
            margin: 10px;
            cursor: pointer;
        }

        .message.left {
            justify-content: flex-start;
            margin: 0; /* 上下の余分なマージンを削除 */
    padding: 0; /* 上下の余分なパディングを削除 */
        }

        .bubble {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px;
            padding: 10px;
            max-width: 70%;
        }
        
         .bottom {
            height: 80px;
            background-color: #f0f0f0;
            padding: 10px;
            position: sticky;
            bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            <a class="circle-button" href="/record">戻る</a>
            <p>{{ $plan->created_at }}</p>
        </div>
        <div class="divider"></div>
        <div class="middle"　id="chat-container">
            <!-- ここにスクロール可能なコンテンツを配置 -->
            <div class="message">
                <div class="bubble right-bubble">どんな予定？</div>
            </div>
            <div class="message left">
                <div class="bubble">{{ $plan->plan_title }}</div>
            </div>
            <div class="message">
                <div class="bubble right-bubble">リンクはある？</div>
            </div>
            <div class="message left">
                <div class="bubble">
    @if ($url !== "ない")
        <a href="{{ $url }}" >Memo URL</a>
    @else
        ない
    @endif
</div>
</div>
            <div class="message">
                <div class="bubble right-bubble">いつの予定？</div>
            </div>
            <div class="message left">
    @if ($formattedDate !== "なし")
        <div class="bubble" id="date">{{$formattedDate}}</div>
    @else
        <div class="bubble" id="date">なし</div>
    @endif
</div>
            
            <div class="message">
            <div class="bubble right-bubble">どこでの予定？</div>
            </div>
            <div class="message left">
            <div class="bubble" >{{$plan->where}}</div>
            </div>
            <div class="message">
            <div class="bubble right-bubble">あなたはその予定をどう思っている？</div>
            </div>
            <div class="message left">
            <div class="bubble">{{$plan->w_think}}</div>
            </div>
            <div class="message">
            <div class="bubble right-bubble">予定の詳細について</div>
            </div>
            <div class="message left">
            <div class="bubble">{{$plan->plan_detail}}</div>
            </div>
            <div class="message">
            <div class="bubble right-bubble">ありがとう！忘れないように記録しておきました。</div>
            </div>
             
            
    </div>
    <div class="bottom">
                <div class="bubble" id="edit-button">編集</div>
                <div class="bubble" id="circle-cancel-button" style="display: none;">やめる</div>
                <button id="send-button" style="display: none;">送信</button>
                <div class="bubble" id="circle-yes-button" style="display: none;">はい</div>
                <div class="bubble" id="circle-no-button" style="display: none;">いいえ</div>
                <div class="bubble" id="circle-dateno-button" style="display: none;">いいえ</div>
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
</body>
<script>
const editButton = document.getElementById("edit-button");
const circleyesbutton = document.getElementById("circle-yes-button");
const circlenobutton = document.getElementById("circle-no-button");
const circledatenobutton = document.getElementById("circle-dateno-button");
const circlecancelbutton = document.getElementById("circle-cancel-button");
const sendButton = document.getElementById("send-button");
const chatContainer = document.querySelector(".middle");
const YesorNo = document.getElementById("yesorno");
const date = document.getElementById("date");
let editMode = false; // 編集モードのフラグ
let pendingMessages = []; 
let messageText;

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

  editButton.addEventListener("click", function () {
    editMode = true;
    editButton.style.display = "none";
    circlecancelbutton.style.display = "block";
});

circlecancelbutton.addEventListener("click", function () {
    editMode = false;
    editButton.style.display = "block";
    circlecancelbutton.style.display = "none";
    if(sendButton){
    sendButton.style.display = "none";
    }
});
// メッセージクリックイベントを設定
chatContainer.addEventListener("click", function (e) {
    if (editMode) { // 編集モードの場合のみ編集可能
        const messageDiv = e.target.closest(".message");

        if (messageDiv && messageDiv.classList.contains("left")) {
            messageText = messageDiv.querySelector(".bubble").textContent;
            const originalMessageIndex = pendingMessages.indexOf(messageText);
            const yesOrNoDiv = messageDiv.querySelector("#yesorno");
            const dateDiv = messageDiv.querySelector("#date");
            if (yesOrNoDiv === e.target){
             // はい・いいえのボタンを表示する
             circlecancelbutton.style.display = "none";
     circleyesbutton.style.display = "block"
     circlenobutton.style.display = "block"
     
      circleyesbutton.addEventListener("click", function () {
        // はいボタンがクリックされた場合の処理
        // ここで「はい」の入力を受け付ける処理を追加
        // ボタンを非表示にし、メッセージフィールドを表示する
        const bubbleDiv = messageDiv.querySelector(".bubble");
        bubbleDiv.textContent = 'はい'; // 選択されたメッセージ

    circlecancelbutton.style.display = "block";    
    circleyesbutton.style.display = "none"
    circlenobutton.style.display = "none"

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;
sendButton.style.display = "block";
    });

circlenobutton.addEventListener("click", function () {
        // いいえボタンがクリックされた場合の処理
        // ここで「いいえ」の入力を受け付ける処理を追加
        // ボタンを非表示にし、メッセージフィールドを表示する
        const bubbleDiv = messageDiv.querySelector(".bubble");
        bubbleDiv.textContent = 'いいえ'; // 選択されたメッセージ
         
        circlecancelbutton.style.display = "block";
        circleyesbutton.style.display = "none"
        circlenobutton.style.display = "none"

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;
    sendButton.style.display = "block";
    });
     } else if (dateDiv === e.target){
             // はい・いいえのボタンを表示する
             circlecancelbutton.style.display = "none";
     document.querySelectorAll("label, select, button#savedate").forEach(element => {
            element.style.display = "block";
        });
     //circledatenobutton.style.display = "none"
     
      savedate.addEventListener("click", function () {
        // はいボタンがクリックされた場合の処理
        // ここで「はい」の入力を受け付ける処理を追加
        // ボタンを非表示にし、メッセージフィールドを表示する
const selectedYear = yearSelect.value;
const selectedMonth = monthSelect.value;
const selectedDay = daySelect.value;
const selectedHour = hourSelect.value;
const selectedMinute = minuteSelect.value;

// 選択された年月日から日付文字列を生成
const formattedDate = `${selectedYear}年${selectedMonth}月${selectedDay}日${selectedHour}時${selectedMinute}分`;
        const bubbleDiv = messageDiv.querySelector(".bubble");
        bubbleDiv.textContent = formattedDate; // 選択されたメッセージ

    circlecancelbutton.style.display = "block";    
    document.querySelectorAll("label, select").forEach(element => {
            element.style.display = "none";
        });
        savedate.style.display = "none"
    circledatenobutton.style.display = "none"

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;
sendButton.style.display = "block";
    });

circledatenobutton.addEventListener("click", function () {
        // いいえボタンがクリックされた場合の処理
        // ここで「いいえ」の入力を受け付ける処理を追加
        // ボタンを非表示にし、メッセージフィールドを表示する
        const bubbleDiv = messageDiv.querySelector(".bubble");
         bubbleDiv.textContent = 'いいえ'; // 選択されたメッセージ
         
        circlecancelbutton.style.display = "block";
        document.querySelectorAll("label, select").forEach(element => {
            element.style.display = "none";
        });
        savedate.style.display = "none"
        circledatenobutton.style.display = "none"

    // スクロールを一番下に移動
    chatContainer.scrollTop = chatContainer.scrollHeight;
    sendButton.style.display = "block";
    });
     } else {
    editMessage(messageDiv, messageText, originalMessageIndex)
            }
        }
    }
});

// メッセージクリック時の処理
function editMessage(messageDiv, messageText, originalMessageIndex) {
editMode = false;
    const bubbleDiv = messageDiv.querySelector(".bubble");
    bubbleDiv.innerHTML = `<input class="edit-input" type="text" value="${messageText}" />`;
    const editInput = bubbleDiv.querySelector(".edit-input");
    editInput.focus();
    editInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            editMode = true;
            const editedText = editInput.value.trim();
            if (editedText !== "") {
                bubbleDiv.innerHTML = editedText;
                 sendButton.style.display = "block";
            }
        }
    });
};

sendButton.addEventListener("click", function (){
    if (editMode) {
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        
        // 編集されたメッセージを格納するオブジェクト
        const editedMessage = {};

        // メッセージの要素を取得
        const messageDivs = chatContainer.querySelectorAll(".message.left");

        // メッセージごとに編集されたテキストを取得してオブジェクトに格納
        messageDivs.forEach((messageDiv, index) => {
            const messageText = messageDiv.querySelector(".bubble").textContent;
            editedMessage[`question${index + 1}`] = messageText;
        });
        
 const planId = {{ $plan->id }};
        // メッセージをサーバーに送信
        fetch(`/record/plan/${planId}/update`, { 
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(editedMessage),
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('メッセージの送信中にエラーが発生しました。');
            }
        })
        .then(data => {
            alert("メッセージが保存されました。");
 window.location.href = "/chatmemo";

        })
        .catch(error => {
            alert(error.message);
        });
    }
});
</script>
</html>
