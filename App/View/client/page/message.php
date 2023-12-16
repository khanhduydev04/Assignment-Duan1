<?php
$user = new User();
$photo = new Photo();
$friend = new Friend();

$user_id = $_SESSION['user']['id'];
$token = $_SESSION['user']['token'];
?>
<main class="container-fluid vh-100">
  <div class="row position-relative h-100" style="padding-top: 56px;">
    <div class="col-lg-3 col-sm-4 col-2 bg-white border-end position-relative p-0">
      <div class="d-flex flex-column justify-content-between h-100">
        <div class="sticky-top p-3 text-center fw-bold shadow-sm fs-4 bg-body-tertiary" style="height: 60px;">
          Đoạn chat
        </div>
        <div class="row">
          <div class="col">
            <div class="scrollable-message px-2">
              <?php
              $list_friend = $friend->getAllFriendByUser($user_id);
              foreach ($list_friend as $friend_data) {
                if ($user_id !== $friend_data['user_id1']) {
                  $row = $user->getUserById($friend_data['user_id1']);
                } else {
                  $row = $user->getUserById($friend_data['user_id2']);
                } ?>

                <div class="d-flex gap-2 w-100 align-items-center p-2 rounded-3 user-message" data-userid="<?= $row['id'] ?>">
                  <?php
                  if (($photo->getNewAvatarByUser($row['id']) != null)) { ?>
                    <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="avata" class="rounded-circle me-2" id="receiver_img" style="width: 50px; height: 50px; object-fit: cover;">
                  <?php } else { ?>
                    <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" id="receiver_img" style="width: 50px; height: 50px; object-fit: cover;">
                  <?php }
                  ?>
                  <p class="fw-semibold m-0" id="receiver_name"><?= $user->getFullnameByUser($row['id']) ?></p>
                </div>
              <?php }
              ?>
            </div>
          </div>
        </div>
        <div class="sticky-bottom p-3 shadow-sm text-center bg-body-tertiary fw-bold" style="height: 60px;">
          BeeSocial
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-sm-8 col-10 bg-white px-0 position-relative">
      <div class="d-flex flex-column justify-content-between h-100" id="chat_area">
      </div>
    </div>
  </div>
</main>
<script>
  $(document).ready(function() {
    let receiver_id = '';

    var conn = new WebSocket('ws://localhost:8080?token=<?= $token ?>');
    conn.onopen = function(e) {
      console.log("Connection established!");
    };

    conn.onclose = function(e) {
      console.log("Connection close!");
    };

    conn.onmessage = function(e) {
      console.log(e.data);

      let data = JSON.parse(e.data);
      let html_data = '';
      let msg_class = '';
      let background_class = '';
      if (data.from == 'Me') {
        msg_class = 'd-flex justify-content-end';
        background_class = 'message-content message-primary';
      } else {
        msg_class = 'd-flex';
        background_class = 'message-content message-secondary';
      }
      if (receiver_id == data.userId || data.from == 'Me') {
        html_data += `<div class='${msg_class}'><p class='${background_class}'>${data.msg}</p></div>`;
        $('.message-area').append(html_data);
        $('.message-area').scrollTop($('.message-area')[0].scrollHeight);
        $('#message-input').val('');
      }
    };

    function make_chat_area(id, image, name) {
      let html =
        `<div class="message-header sticky-top shadow-sm bg-white" style="z-index: 5;">
          <a href="index.php?ctrl=profile&id=${id}" class="d-flex gap-2 align-items-center p-2 user-message text-dark">
            <img src="${image}" alt="avata" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover;">
            <p class="fw-semibold m-0">${name}</p>
          </a>
        </div>
        <div class="message-area overflow-y-auto pt-3 px-2" style="flex: 1;">
        </div>
        <div class="sticky-bottom p-3">
          <form action="" method="post" id="chat_form">
            <input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>">
            <div class="input-group">
              <textarea name="message" id="message-input" cols="30" rows="10" class="form-control" style="max-height: 30px;" required></textarea>
              <div class="input-group-append">
                <button type="submit" name="send" id="send" class="btn btn-primary">
                  <i class="fa-solid fa-paper-plane"></i>
                </button>
              </div>
            </div>
          </form>
        </div>`;
      $('#chat_area').html(html);
    }

    $(document).on('click', '.user-message', function() {
      receiver_id = $(this).data('userid');
      let form_user_id = <?= $user_id ?>;
      let receiver_img_src = $(this).find('#receiver_img').attr('src');
      let receiver_name_text = $(this).find('#receiver_name').text();

      make_chat_area(receiver_id, receiver_img_src, receiver_name_text);

      $.ajax({
        url: './ajax.php',
        type: 'POST',
        data: {
          action: 'fetch_chat',
          to_user_id: receiver_id,
          form_user_id: form_user_id
        },
        dataType: 'JSON',
        success: function(data) {
          if (data.length > 0) {
            let html_message = '';
            for (let index = 0; index < data.length; index++) {
              let msg_class = '';
              let background_class = '';
              if (data[index].user_id1 == form_user_id) {
                msg_class = 'd-flex justify-content-end';
                background_class = 'message-content message-primary';
              } else {
                msg_class = 'd-flex';
                background_class = 'message-content message-secondary';
              }
              html_message +=
                `<div class='${msg_class}'><p class='${background_class}'>${data[index].content}</p></div>`;
            }
            $('.message-area').html(html_message);
            $('.message-area').scrollTop($('.message-area')[0].scrollHeight);
          }
        }
      });
    });

    $(document).on('submit', '#chat_form', function(event) {
      event.preventDefault();
      let user_id = $('#user_id').val();
      let message = $('#message-input').val();
      let data = {
        userId: user_id,
        msg: message,
        receiver_userId: receiver_id
      }
      conn.send(JSON.stringify(data));
      console.log(data);
    });
  });
</script>