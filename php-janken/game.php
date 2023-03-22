<?php
  //phpのセッションを開始
  session_start();

  //入力されたユーザー名の取得、値がなければから文字をセット
  $userName = isset($_POST['user_name']) ? $_POST['user_name'] : '';
  //userNameを後続の処理で使いたいため、変数に代入
  if (empty($userName) && isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
  }

  //バリデーション
  $errorMessages = [];
  if (empty($userName)) {
    array_push($errorMessages, "ユーザー名が空です。ユーザー名を入力してください。");
  }

  //mb_strlen関数で、渡した変数の文字数が取得できる
  // if (8 < mb_strlen($userName)) {
  //   array_push($errorMessages, "ユーザー名は8文字以内で入力してください。");
  // }

  //エラー数をカウント
  if (0 < count($errorMessages)) {
    $_SESSION["errors"] = $errorMessages;
    //header関数をつかってindex.phpにリダイレクト
    header("location: index.php");
    exit;
  }

  $_SESSION['userName'] = $userName;
  //$_SESSIONや$_POSTはPHPのスーパーグローバル変数

  $userHand = null;
  $computerHand = null;
  if (isset($_POST['user_hand'])) {
      $userHand = $_POST['user_hand'];

      // コンピューターが出す手を決める
      $handTypes = ['rock', 'scissors', 'paper'];
      $handImages = ['rock' => 'images/janken_gu.png', 'scissors' => 'images/janken_choki.png', 'paper' => 'images/janken_pa.png'];
      //ランダムに0,1,2のいずれか選び、配列handTypesから文字列取得

      $number = mt_rand(0, 2);
      $computerHand = $handTypes[$number];

      $computerHandImage = $handImages[$handTypes[$number]];
      $userHandImage = $handImages[$userHand];

      $winnerFlag = 0;
      //userが買ったら1，コンピュータが勝ったら2になる
      if ($computerHand === $userHand) {
      } else if ($computerHand === 'rock' && $userHand === 'scissors') {
          $winnerFlag = 1;
      } else if ($computerHand === 'scissors' && $userHand === 'paper') {
          $winnerFlag = 1;
      }else if ($computerHand === 'paper' && $userHand === 'rock') {
          $winnerFlag = 1;
      } else {
          $winnerFlag = 2;
      }
    }
?>
<html>
  <?php require_once 'parts/header.php' ?>
  <body>
    <?php require_once 'parts/navibar.php' ?>
    <!--javascriptで-->
    <script lang="javascript">
      function submitUserHand(hand){
        document.querySelector("#user_hand").value = hand;
        document.querySelector("#select_hand_form").submit();
      }
    </script>
    <div class="container">
      <!--じゃんけんの手が決まっていたら表示する-->
      <?php if ($userHand && $computerHand): ?>
      <div>
        <!--winnerFlagで条件分岐-->
        <?php if ($winnerFlag === 0): ?>
          <div class="fs-2 blue text-danger">あいこです</div>
        <?php elseif ($winnerFlag === 1): ?>
          <div class="fs-2 blue text-danger">コンピューターの勝ち</div>
        <?php elseif ($winnerFlag === 2): ?>
          <div class="fs-2 blue text-danger"><?php echo $userName; ?>さんの勝ち</div>
        <?php endif; ?>
        <div class="fs-4">n回のうち、n回勝ちました。</div>
      </div>
      <div class="d-flex justify-content-center align-items-center flex-column mt-2">
        <div class="border rounded p-3 mt-2">
            <img src="<?php echo $computerHandImage; ?>" width="100" class="rounded" />
        </div>
        <div class="d-flex justify-content-center fs-2 mt-1 mb-1">
            VS
        </div>
        <div class="border rounded p-3">
            <img src="<?php echo $userHandImage; ?>" width="100" class="rounded" />
        </div>
      </div>
      <?php else: ?>
         <div class="fs-2 blue text-danger">手を選んでください。</div>
      <?php endif; ?>

      <!--actionでgame.phpを指定しているので、自画面にpostで送信される-->
      <form method="post" action="game.php" id="select_hand_form">
        <!--hiddenになっているinputタグに、押された手:変数handが送信されてくる-->
        <input type="hidden" name="user_hand" id="user_hand" value="" />
        <div class="d-flex justify-content-evenly mt-5">
          <!--onclickを使うことで、javascriptのfunctionを作動させる-->
            <button class="btn btn-outline-primary" onclick="submitUserHand('rock');">
                <img src="images/janken_gu.png" width="80" class="rounded" />
            </button>
            <button class="btn btn-outline-primary" onclick="submitUserHand('scissors');">
                <img src="images/janken_choki.png" width="80" class="rounded" />
            </button>
            <button class="btn btn-outline-primary" onclick="submitUserHand('paper')">
                <img src="images/janken_pa.png" width="80" class="rounded" />
            </button>
        </div>
      </form>
    </div>
  </body>
</html>