<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Webじゃんけんゲーム</a>
    <?php if (isset($_SESSION['userName'])): ?>
         <div class="text-white">ようこそ、<?php echo $_SESSION['userName'] ?>さん</div>
    <?php endif; ?>
  </div>
</nav>