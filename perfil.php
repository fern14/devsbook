<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
// verificando qual página está ativa
$activeMenu = 'profile';
$user = [];
$feed = [];

$id = filter_input(INPUT_GET, 'id');

if (!$id) {
  $id = $userInfo->id;
}

if ($id != $userInfo->id) {
  $activeMenu = '';
}

$postDao = new PostDaoMysql($pdo);
$userDao = new UserDaoMysql($pdo);
// pegar informações do usuario
$user = $userDao->findById($id, true);
if (!$user) {
  header("Location: " . $base);
  exit;
}

$dateFrom = new DateTime($user->birthdate);
$dateTo = new DateTime('today');
// pegar os anos do usuario
$user->ageYears = $dateFrom->diff($dateTo)->y;

// pegar o feed do usuario
$feed = $postDao->getUserFeed($id);

// verificar se eu sigo esse usuario

// $feed = $postDao->getHomeFeed($userInfo->id);

require 'partials/header.php';
require 'partials/menu.php';

?>

<section class="feed">

  <div class="row">
    <div class="box flex-1 border-top-flat">
      <div class="box-body">
        <div class="profile-cover" style="background-image: url('<?= $base; ?>media/covers/<?= $user->cover; ?>');"></div>
        <div class="profile-info m-20 row">
          <div class="profile-info-avatar">
            <img src="<?= $base; ?>media/avatars/<?= $user->avatar; ?>" />
          </div>
          <div class="profile-info-name">
            <div class="profile-info-name-text"><?= $user->name; ?></div>
            <div class="profile-info-location"><?= $user->city; ?></div>
          </div>
          <div class="profile-info-data row">
            <div class="profile-info-item m-width-20">
              <div class="profile-info-item-n"><?php echo count($user->followers); ?></div>
              <div class="profile-info-item-s">Seguidores</div>
            </div>
            <div class="profile-info-item m-width-20">
              <div class="profile-info-item-n"><?php echo count($user->following); ?></div>
              <div class="profile-info-item-s">Seguindo</div>
            </div>
            <div class="profile-info-item m-width-20">
              <div class="profile-info-item-n"><?php echo count($user->photos); ?></div>
              <div class="profile-info-item-s">Fotos</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="column side pr-5">

      <div class="box">
        <div class="box-body">

          <div class="user-info-mini">
            <img src="<?= $base; ?>assets/images/calendar.png" />
            <?= date('d/m/Y', strtotime($user->birthdate)); ?> (<?= $user->ageYears; ?> anos)
          </div>

          <div class="user-info-mini">
            <img src="<?= $base; ?>assets/images/pin.png" />
            <?= $user->city ?>, Brasil
          </div>

          <div class="user-info-mini">
            <img src="<?= $base; ?>assets/images/work.png" />
            <?= $user->work; ?>
          </div>

        </div>
      </div>

      <div class="box">
        <div class="box-header m-10">
          <div class="box-header-text">
            Seguindo
            <span>(<?php echo count($user->following); ?>)</span>
          </div>
          <div class="box-header-buttons">
            <a href="<?= $base ?>amigos.php?id=<?= $user->id; ?>">ver todos</a>
          </div>
        </div>
        <div class="box-body friend-list">
          <?php if ($user->following > 0) : ?>
            <?php foreach ($user->following as $item) : ?>
              <div class="friend-icon">
                <a href="<?= $base ?>perfil.php?id=<?= $item->id; ?>">
                  <div class="friend-icon-avatar">
                    <img src="<?= $base; ?>media/avatars/<?= $item->avatar; ?>" />
                  </div>
                  <div class="friend-icon-name">
                    <?php echo $item->name; ?>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
    <div class="column pl-5">

      <div class="box">
        <div class="box-header m-10">
          <div class="box-header-text">
            Fotos
            <span>(<?php echo count($user->photos); ?>)</span>
          </div>
          <div class="box-header-buttons">
            <a href="<?= $base ?>fotos.php?id=<?= $user->id; ?>">ver todos</a>
          </div>
        </div>
        <div class="box-body row m-20">

          <?php if (count($user->photos) > 0) : ?>
            <?php foreach ($user->photos as $key => $item) : ?>
              <div class="user-photo-item">
                <a href="#modal-<?= $key; ?>" rel="modal:open">
                  <img src="<?= $base; ?>media/uploads/<?= $item->body; ?>" />
                </a>
                <div id="modal-<?= $key; ?>" style="display:none">
                  <img src="<?= $base; ?>media/uploads/<?= $item->body; ?>" />
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <?php if ($id == $userInfo->id) : ?>
        <?php require 'partials/feed-editor.php'; ?>
      <?php endif; ?>

      <?php if (count($feed) > 0) : ?>
        <?php foreach ($feed as $item) : ?>
          <?php require 'partials/feed-item.php'; ?>
        <?php endforeach; ?>
      <?php else : ?>
        Não há postagens deste usuário
      <?php endif; ?>
    </div>
  </div>
</section>

<?php
require 'partials/footer.php'
?>