<?php require_once('../../private/initialize.php'); ?>

<?php 
  require_user_login();
	//checks if the page id given value exists, if so it sets the variable $id to it
	//else sets $id to 1
	$id = $_GET['id'] ?? 1;

	$user_game = find_user_game_by_id($id);
?>
  <div id="message">
	   <li><?php echo $_SESSION['statusmsg'] ?? '';?></li>
     <?php unset($_SESSION['statusmsg']); ?>
  </div>

<h1>Game Submitted : <?php 
$game = find_game_by_id($user_game['game_id']);
echo hsc($game['title']); 
?></h1>

<div class="attributes">
  <dl>
    <dt>Time Inputted</dt>
    <dd><?php echo hsc($user_game['time_input']); ?></dd>
  </dl>
  <dl>
    <dt>Completed</dt>
    <dd><?php if($user_game['completed'] == 1){ echo "True"; }else{ echo "False";} ?></dd>
  </dl>
  <dl>
    <dt>Exp. Earned</dt>
    <dd><?php if($user_game['completed'] == 1){ 
                  $value = 300;
                  $user = find_user_by_id($user_game['user_id']);

                  //put this into $leveled when adding level check
                  $leveled = add_exp_query($user, $value);
                  
                  //getting user again after we changed the value. 
                  $updateduser = find_user_by_id($user_game['user_id']);
                  echo "You earned " . $value . " exp. Your Exp is Now " . ($updateduser['exp']) . ".";

                  //setting new level and displaying it
                  $level = set_level($updateduser);
                  if ($level){

                    //getting user again.
                    $updateduser2 = find_user_by_id($user_game['user_id']);
                    echo "<br>You Leveled Up! Level is now " . $updateduser2['lev'];
                  }


              }else{ echo "Complete the game to Earn a cool 300 Exp.";}
        ?></dd>
  </dl>
  <dl>
    <dt>Format</dt>
    <dd><?php echo hsc($user_game['format']); ?></dd>
  </dl>
  <dl>
    <dt>Status</dt>
    <dd><?php echo hsc($user_game['status']); ?></dd>
  </dl>
</div>

<br>

<a href="<?php echo url_for('viewgamebase.php'); ?>"> << Back to List</a>


