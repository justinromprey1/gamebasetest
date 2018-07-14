<?php require_once('../private/initialize.php'); ?>

<?php
    require_user_login();
    $game_set = find_all_games();
    $badge_set = find_all_badges();
    $current_user = find_user_by_username($_SESSION['user_login']) ?? '';
    $c_badge_set = find_c_badges_by_user_id($current_user['id']);
    $user_game_set = get_user_games_query($current_user['id']);
    $user_badge_set = get_user_badges_query($current_user['id']);

?>

<?php $page_title = 'Your Gamebase'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>
<h3> Hello <?php echo $current_user['username'];?>, Welcome to your Gamebase!</h3>
<h2> Current Exp: <?php echo $current_user['exp'];?></h2>
<h2> Level: <?php echo $current_user['lev'];?></h2>


<div id="content">
  <div class="actions">
      <a class="action" href="<?php echo url_for('viewallgames.php') ?>">View All Games</a>
      <?php echo "  /  "; ?>
      <a class="action" href="<?php echo url_for('viewallbadges.php') ?>">View All Badges</a>
  </div>

  <div class="Games Played listing">
    <h1>Games Played</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/user_games/new.php') ?>">Add Game Played</a>
    </div>

    <table class="list">
      <tr>
        <th>Game Played</th>
        <th>System</th>
        <th>Developer</th>
        <th>Publisher</th>
        <th>Genre</th>
        <th>Year</th>
        <th>Date Submitted</th>
        <th>Completed?</th>
        <th>User Rating</th>
        <th>Format Played On</th>
        <th>Status</th>
      </tr>

      <?php while($user_game = mysqli_fetch_assoc($user_game_set)) { ?>
        <tr>
          <td><?php echo hsc($user_game['title']); ?></td>
          <td><?php echo hsc($user_game['system']); ?></td>
          <td><?php echo hsc($user_game['dev']); ?></td>
          <td><?php echo hsc($user_game['pub']); ?></td>
          <td><?php echo hsc($user_game['genre']); ?></td>
          <td><?php echo hsc($user_game['year']); ?></td>
          <td><?php echo hsc($user_game['time_input']); ?></td>
          <td><?php if($user_game['completed'] == 1){ echo "True";}else{ echo "False";} ?></td>
          <td><?php echo hsc($user_game['user_rating']); ?></td>
          <td><?php echo hsc($user_game['format']); ?></td>
          <td><?php echo hsc($user_game['status']); ?></td>
        </tr>
      <?php } ?>
    </table>

    <?php 
      mysqli_free_result($user_game_set);
    ?>

  </div>

  <div class="Badges Earned listing">
    <h1>Badges Earned</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/user_badges/new.php') ?>">Add Badge Earned</a>
    </div>

    <table class="list">
      <tr>
        <th>Game</th>
        <th>Badge</th>
        <th>Requirement</th>
        <th>Difficulty</th>
        <th>Time Earned</th>
      </tr>

      <?php while($user_badge = mysqli_fetch_assoc($user_badge_set)) { ?>
        <tr>
          <td><?php echo hsc($user_badge['Game']); ?></td>
          <td><?php echo hsc($user_badge['Title']); ?></td>
          <td><?php echo hsc($user_badge['req']); ?></td>
          <td><?php echo hsc($user_badge['diff']); ?></td>
          <td><?php echo hsc($user_badge['time_complete']); ?></td>
        </tr>
      <?php } ?>
    </table>

    <?php 
      mysqli_free_result($user_badge_set);
    ?>

  </div>


  <div class="custom badge listing">
    <h1>Your Custom Badges</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/custombadges/new.php') ?>">Create Custom Badge</a>
    </div>

    <table class="list">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Requirement</th>
        <th>Difficulty</th>
        <th>Completed?</th>
        <th>Game ID</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <?php while($c_badge = mysqli_fetch_assoc($c_badge_set)) { ?>
        <tr>
          <td><?php echo hsc($c_badge['id']); ?></td> 
          <td><?php echo hsc($c_badge['title']); ?></td>
          <td><?php echo hsc($c_badge['req']); ?></td>
          <td><?php echo hsc($c_badge['diff']); ?></td>
          <td><?php if($c_badge['completed'] == 1){ echo "True";}else{ echo "False";} ?></td>
          <td><?php $game = find_game_by_id($c_badge['game_id']);
              echo hsc($game['title']); ?></td>
          <td><a class="action" href="<?php echo url_for('custombadges/edit.php?id='.hsc(urle($c_badge['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('custombadges/delete.php?id='. hsc(urle($c_badge['id']))); ?>">Delete</a></td>
        </tr>
      <?php } ?>
    </table>

    <?php 
      mysqli_free_result($c_badge_set);
    ?>

  </div>



</div>
<br>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>