<div class="footer">
  <div id="footer_menu"><img onClick="location.href='main.php'" src="../img/Project2_Home.png" alt="Main_menu"></div>
  <div id="footer_channels"><img onClick="location.href='search.php'" src="../img/Project2_channels.png" alt="Channels"></div>
  <div class="create-btn" id="footer_add_post"><img onclick="Create()" src="../img/Project2_add_post.png" alt="Add_post">
    <div class="popupCreate" id="CreatePopup">
      <div>
        <p onClick="location.href='addPost.php'">Create Post</p>
      </div>
      <div>
        <p onClick="location.href='createChannel.php'">Create Channel</p>
      </div>
    </div>
  </div>
  <div id="footer_notifications"><img onClick="location.href='notification.php'" src="../img/Project2_notification.png" alt="Notifications"></div>
  <div id="footer_profile"><img onClick="location.href='profile.php'" src="../img/Project2_profile.png" alt="Profile"></div>
</div>
<script>
  function Create() {
    var popup = document.getElementById("CreatePopup");
    popup.classList.toggle("showCreatePopup");
  }
</script>