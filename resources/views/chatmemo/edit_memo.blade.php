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
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <!-- 上部 -->
            <a class="circle-button" href="/record">戻る</a>
            <p>{{ $memo->created_at }}</p>
        </div>
        <div class="divider"></div>
        <div class="middle"　id="chat-container">
            <!-- ここにスクロール可能なコンテンツを配置 -->
            <div class="message">
                <div class="bubble right-bubble">何について話してくれますか？</div>
            </div>
            <div class="message left">
                <div class="bubble">{{ $memo->memo_title }}</div>
            </div>
            <div class="message">
                <div class="bubble right-bubble">リンクはある？</div>
            </div>
            <div class="message left">
                <div class="bubble"><div>
    @if ($url !== "ない")
        <a href="{{ $url }}" >Memo URL</a>
    @else
        <div class="message　left">ない</div>
    @endif
</div></div>
            </div>
            <div class="message">
                <div class="bubble right-bubble">これは重要なこと？</div>
            </div>
            <div class="message left">
                <div class="bubble" id=yesorno >{{$memo->important}}</div>
            </div>
            <div class="message">
                <div class="bubble right-bubble">どんなこと？</div>
            </div>
            <div class="message left">
                <div class="bubble">{{$memo->about}}</div>
            </div>
            <div class="message">
                <div class="bubble right-bubble">どう思った？</div>
            </div>
            <div class="message left">
                <div class="bubble">{{$memo->w_think}}</div>
            </div>
            <div class="message">
                <div class="bubble right-bubble">ありがとう！忘れないように記録しました。</div>
            </div>
             
            
    </div>
    <div class="bottom">
                <div class="bubble" id="edit-button">編集</div>
                <div class="bubble" id="circle-cancel-button" style="display: none;">やめる</div>
                <button id="send-button" style="display: none;">送信</button>
                <div class="bubble" id="circle-yes-button" style="display: none;">はい</div>
                <div class="bubble" id="circle-no-button" style="display: none;">いいえ</div>
            </div>
        </div>
</body>
<script>
const editButton = document.getElementById("edit-button");
const circleyesbutton = document.getElementById("circle-yes-button");
const circlenobutton = document.getElementById("circle-no-button");
const circlecancelbutton = document.getElementById("circle-cancel-button");
const sendButton = document.getElementById("send-button");
const chatContainer = document.querySelector(".middle");
const YesorNo = document.getElementById("yesorno");
let editMode = false; // 編集モードのフラグ
let pendingMessages = []; 
let messageText;

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
            const messageText = messageDiv.querySelector(".bubble").textContent;
            const originalMessageIndex = pendingMessages.indexOf(messageText);
            const yesOrNoDiv = messageDiv.querySelector("#yesorno");
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
     }else {
            editMessage(messageDiv, messageText, originalMessageIndex);
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
// 送信ボタンクリック時の処理
sendButton.addEventListener("click", function () {
if (editMode) {
 // 編集されたメッセージを格納するオブジェクト
        const editedMessage = {};

        // メッセージの要素を取得
        const messageDivs = chatContainer.querySelectorAll(".message.left");

        // メッセージごとに編集されたテキストを取得してオブジェクトに格納
        messageDivs.forEach((messageDiv, index) => {
            const messageText = messageDiv.querySelector(".bubble").textContent;
            editedMessage[`question${index + 1}`] = messageText;
        });
        // サーバーにメッセージを送信してアップデート
        sendMessageToServer(editedMessage);
        editMode = false;
    }
});


function sendMessageToServer(editedMessage) {
    if (editMode) {
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

 const memoId = {{ $memo->id }};
        // メッセージをサーバーに送信
        fetch(`/record/memo/${memoId}/update`, { 
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
};
</script>
</html>
