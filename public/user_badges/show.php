<?php require_once('../../private/initialize.php'); ?>

<?php 
  require_user_login();
	//checks if the page id given value exists, if so it sets the variable $id to it
	//else sets $id to 1
	$id = $_GET['id'] ?? 1;

	$user_badge = find_user_badge_by_id($id);
?>
  <div id="message">
	   <li><?php echo $_SESSION['statusmsg'] ?? '';?></li>
     <?php unset($_SESSION['statusmsg']); ?>
  </div>

<h1>Badge Earned : <?php 
$badge = find_badges_by_id($user_badge['badge_id']);
echo hsc($badge['title']); 
?></h1>

<div class="attributes">
  <dl>
    <dt>Exp. Earned</dt>
    <dd><?php $value = calc_points_badge($badge['diff']);
              $user = find_user_by_id($user_badge['user_id']);

              //put this into $leveled when adding level check
              $leveled = add_exp_query($user, $value);

              //getting user again after we changed the value. 
              $updateduser = find_user_by_id($user_badge['user_id']);
              echo "You earned " . $value . " exp. Your Exp is Now " . ($updateduser['exp']) . ".";

              //setting new level and displaying it
              $level = set_level($updateduser);
                  if ($level){

                    //getting user again.
                    $updateduser2 = find_user_by_id($user_badge['user_id']);
                    echo "<br>You Leveled Up! Level is now " . $updateduser2['lev'];
                  }
     ?></dd>
  </dl>
  <dl>
  <dl>
    <dt>Time Earned</dt>
    <dd><?php echo hsc($user_badge['time_complete']); ?></dd>
  </dl>
</div>

<br>

<a href="<?php echo url_for('viewgamebase.php'); ?>"> << Back to List</a>


