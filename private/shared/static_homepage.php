

<div id="content">

  <h2>Welcome to GameBase.</h2>

  <p>
    Here you can track and list games you've played, completed, or want to play.
    <br>
    You can track Badges; which are goals or achievements for any game you upload to your Gamebase. You may create Custom Badges too if want to challenge yourself and track your progress. 
  </p>
  <h3>Please begin by Logging In, or Create an account if you are new here. ^.^</h3>

  <ul>
    <li><a href="<?php echo url_for('usercreate.php'); ?>">Create Account</a></li>
    <li><a href="<?php echo url_for('userlogin.php'); ?>">User Login</a>/<a href="<?php echo url_for('userlogout.php'); ?>">Logout</a></li>
    <li><a href="<?php echo url_for('viewgamebase.php'); ?>">View GameBase</a>
      <?php if(!isset($_SESSION['user_id'])){ echo "You must log in to view your GameBase!"; } ?></li>
  </ul>



</div>
