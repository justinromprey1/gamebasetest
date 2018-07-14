<?php require_once('../private/initialize.php'); ?>

<?php
    require_user_login();
    $game_set = find_all_games();
    $badge_set = find_all_badges();


?>

<?php $page_title = 'Games'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to List</a>

  <div class="Games listing">
    <h1>All Games</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('') ?>">Submit Game</a>
  	</div>

    <table class="list">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>System</th>
        <th>Developer</th>
        <th>Publisher</th>
        <th>Genre</th>
        <th>Year</th>
      </tr>

      <?php while($game = mysqli_fetch_assoc($game_set)) { ?>
        <tr>
          <td><?php echo hsc($game['id']); ?></td> 
          <td><?php echo hsc($game['title']); ?></td>
          <td><?php echo hsc($game['system']); ?></td>
          <td><?php echo hsc($game['dev']); ?></td>
          <td><?php echo hsc($game['pub']); ?></td>
          <td><?php echo hsc($game['genre']); ?></td>
          <td><?php echo hsc($game['year']); ?></td>
      	</tr>
      <?php } ?>
    </table>

    <?php 
      mysqli_free_result($game_set);
    ?>

  </div>
</div>
<br>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>