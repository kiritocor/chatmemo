

## chatmemoについて

・基本的にトップページ、会話の記録ページ、記録した内容を見るページ、メモの詳細・編集ページの4つの機能を有しているメモアプリです。

# 使用技術
使用したもの

使用言語 ：html, css, JavaScript, php

フレームワーク ：laravel

DB ：MariaDB

ツール ：chatGPT

# トップページ
・トップページのサイドバーではクリックすることで上3つは表示非表示を変えることが出来、下２つで会話セクション、記録セクションのページへ飛ぶことが出来ます。

・直近のメモでは最近記録したメモが見れます。

・予定やるべきことではtodoが見れます。基本は未解決のtodoが表示されており、未解決のtodoはクリックすることで解決タブへ送ることが出来ます。
解決タブを押すと解決されたtodoが見れます。

・カレンダーでは今日の日付が青く表示されており、予定などがあった場合その予定、締め切りがある日付は赤く表示されます。

# 会話
・会話セクションでは4つのジャンルに分かれてメモを記録することが出来ます。

・メモの記録では、文字を入力、ボタンを押す、日時を選択することで記録することが出来ます。

# 記録
・記録セクションでは、メモの一覧を見ることができ、タグをつけたりフィルタリングすることが出来ます。

・タグは作成でき、作成したタグは選ぶの中にあるタグをドラッグアンドドロップでメモのタイトルにつけることで適用出来ます。

・メモのジャンル、重要度でフィルタリングが出来、上の検索バーでメモのタイトルを入力することでその名前のタイトルにフィルタリングすることが出来ます。

・記録ページなどから、メモのタイトルをクリックすると詳細編集ページに飛ぶことが出来ます。

# 編集

編集ボタンを押し、編集したいメッセージをクリックすることでメモを違う文字にしたり、はいかいいえを選択できたり、日時を変更出来ます。

# 制作背景
・自分の考えや思ったことを既存のアプリでメモするとき、手軽に扱えるテンプレートや形式がないため、本当にメモしたいことが100%メモできていない
というという課題、またメモした内容をもっと視覚的に見やすくしたいという課題を解決するため、普段チャット系のアプリがメモ代わりになっていることに着想を得て制作しました。

工夫した点

・とにかく使用するストレスを減らすこと、見やすいことを意識して、非同期の処理を多く採用しました。その結果、ページ数が減り、リダイレクトされることが少なく、画面をすらすら動かすことができています。

・文字と文字が重なったりしないようcssに注意を払い、多くの文字情報は折りたためるようにし、画面をすっきりさせることが可能になりました。

・文字を入力するのみではなく、はいかいいえの選択肢、時間の選択肢を用意することによってメモを考える負担を減らしました。また、文字の入力、質問のふるまいもチャットらしくわかりやすいです。
