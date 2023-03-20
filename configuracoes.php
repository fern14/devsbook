<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
// verificando qual página está ativa
$activeMenu = 'config';

$userDao = new UserDaoMysql($pdo);

require 'partials/header.php';
require 'partials/menu.php';

?>

<section class="feed mt-10">

  <h1>Configurações</h1>
  <form class="config-form" enctype="multipart/form-data" action="configuracoes_action.php" method="POST">
    <label for="">
      Novo Avatar: <br>
      <input type="file" name="avatar" id=""> <br>

      <img class="mini" src="<?= $base ?>media/avatars/<?= $userInfo->avatar; ?>" alt="">
    </label>

    <label for="">
      Nova Capa: <br>
      <input type="file" name="cover" id=""> <br>

      <img src="<?= $base ?>media/covers/<?= $userInfo->cover; ?>" alt="">
    </label>

    <hr>

    <label for="">
      Nome Completo: <br>
      <input type="text" name="name" value="<?= $userInfo->name; ?>">
    </label>

    <label for="">
      E-mail: <br>
      <input type="email" name="email" id="" value="<?= $userInfo->email; ?>">
    </label>

    <label for="">
      Data de Nascimento: <br>
      <input type="text" name="birthdate" id="birthdate" value="<?= date('d-m-Y', strtotime($userInfo->birthdate)); ?>">
    </label>

    <label for="">
      Cidade: <br>
      <input type="text" name="city" id="" value="<?= $userInfo->city; ?>">
    </label>

    <label for="">
      Trabalho: <br>
      <input type="text" name="work" id="" value="<?= $userInfo->work; ?>">
    </label>

    <hr>

    <label for="">
      Nova Senha: <br>
      <input type="password" name="password" id="">
    </label>

    <label for="">
      Confirmar Nova Senha: <br>
      <input type="password" name="password_confirmation" id="">
    </label>

    <button class="button">Salvar</button>

  </form>

</section>

<script src="https://unpkg.com/imask"></script>
<script>
  IMask(
    document.getElementById('birthdate'), {
      mask: '00/00/0000'
    }
  );
</script>

<?php
require 'partials/footer.php'
?>