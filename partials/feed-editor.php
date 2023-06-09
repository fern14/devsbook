<div class="box feed-new">
  <div class="box-body">
    <div class="feed-new-editor m-10 row">
      <div class="feed-new-avatar">
        <img src="<?= $base; ?>media/avatars/<?= $userInfo->avatar; ?>" />
      </div>
      <div class="feed-new-input-placeholder">
        O que você está pensando, <?php echo $firstName ?>?
      </div>
      <div class="feed-new-input" contenteditable="true"></div>
      <div class="feed-new-send">
        <img src="<?= $base; ?>assets/images/send.png" />
      </div>
      <form class="feed-new-form" action="<?= $base; ?>feed_editor_action.php" method="POST">
        <input type="hidden" name="body">
      </form>
    </div>
  </div>
</div>

<script>
  let feedInput = document.querySelector('.feed-new-input');
  let feedSubmit = document.querySelector('.feed-new-send');
  let feedForm = document.querySelector('.feed-new-form');

  feedSubmit.addEventListener('click', (e) => {
    let value = feedInput.innerText.trim();

    console.log(value);

    feedForm.querySelector('input[name=body]').value = value;
    feedForm.submit();
  })
</script>