<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <!-- 上部 -->
            <a class="circle-back-button" href="chatmemo_qpage.html">戻る</a>
            <p>会話</p>
        </div>
        <div class="divider"></div>
        <div class="middle">
            <!-- ここにスクロール可能なコンテンツを配置 -->
            <div id="chat-container">
                <div class="message">
                    <div class="bubble">1. こんにちは、これは右揃えのメッセージです。</div>
                </div>
            </div>
            <!-- 繰り返しコンテンツを追加してスクロール可能に -->
        </div>
        <div class="divider"></div>
        <div class="bottom">
            <div id="input-container">
                <input type="text" id="message-input" placeholder="メッセージを入力...">
                <button id="send-button">送信</button>
                <div id="store-button-container">
                    <input type="submit" id="store-button" value="store"/>
                </div>
            </div>
        </div>
    </div>

    <script>
        const chatContainer = document.getElementById("chat-container");
        const messageInput = document.getElementById("message-input");
        const sendButton = document.getElementById("send-button");
        const storeButtonContainer = document.getElementById("store-button-container");
        const storeButton = document.getElementById("store-button");
        const fixedMessages = [
            "2. これは2番目の右揃えのメッセージです。",
            "3. これは3番目の右揃えのメッセージです。",
            "4. これは4番目の右揃えのメッセージです。",
            "5. これは5番目の右揃えのメッセージです。",
        ];

        let leftMessages = [];
        let currentIndex = 0;
        let inputFormHidden = false;

        // メッセージ送信時の処理
        function sendMessage() {
            const messageText = messageInput.value.trim();
            if (messageText === "") return;

            // ユーザーの左揃えメッセージを表示
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("message", "left");
            messageDiv.innerHTML = `<div class="bubble">${messageText}</div>`;
            chatContainer.appendChild(messageDiv);
            leftMessages.push(messageText);

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

            // 左揃えのメッセージが5回入力されたら入力フォームを非表示にする
            if (leftMessages.length >= 5 && !inputFormHidden) {
                messageInput.style.display = "none";
                sendButton.style.display = "none";
                storeButtonContainer.style.display = "block";
                inputFormHidden = true;
            }

            messageInput.value = "";
        }

        // メッセージクリック時の処理
        function editMessage(messageDiv, messageText) {
            const bubbleDiv = messageDiv.querySelector(".bubble");
            bubbleDiv.innerHTML = `<input class="edit-input" type="text" value="${messageText}" />`;
            const editInput = bubbleDiv.querySelector(".edit-input");
            editInput.focus();
            editInput.addEventListener("keydown", function (e) {
                if (e.key === "Enter") {
                    const editedText = editInput.value.trim();
                    if (editedText !== "") {
                        bubbleDiv.innerHTML = editedText;
                    }
                }
            });
        }

        // メッセージクリックイベントを設定
        chatContainer.addEventListener("click", function (e) {
            const messageDiv = e.target.closest(".message");
            if (messageDiv && messageDiv.classList.contains("left")) {
                const bubbleDiv = messageDiv.querySelector(".bubble");
                const messageText = bubbleDiv.textContent;
                editMessage(messageDiv, messageText);
            }
        });

        // 送信ボタンクリック時の処理
        sendButton.addEventListener("click", sendMessage);

        // storeボタンクリック時の処理
        storeButton.addEventListener("click", function() {
            // storeボタンがクリックされたときの処理を追加
            alert("Store ボタンがクリックされました。");
        });

        // テキストボックスでEnterキーを押したときの処理
        messageInput.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                sendMessage();
            }
        });
    </script>
</body>
</html>
