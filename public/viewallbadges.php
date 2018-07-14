<?php require_once('../private/initialize.php'); ?>

<?php
    require_user_login();
    $game_set = find_all_games();
    $badge_set = find_all_badges();

?>

<?php $page_title = 'Badges'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

	<a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to List</a>
	
	<div class="Badges listing">
    <h1>All Badges</h1>

    <table class="list">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Requirement</th>
        <th>Difficulty</th>
        <th>Game ID</th>
        
      </tr>

      <?php while($badge = mysqli_fetch_assoc($badge_set)) { ?>
        <tr>
          <td><?php echo hsc($badge['id']); ?></td> 
          <td><?php echo hsc($badge['title']); ?></td>
          <td><?php echo hsc($badge['req']); ?></td>
          <td><?php echo hsc($badge['diff']); ?></td>
          <td><?php $game = find_game_by_id($badge['game_id']);
              echo hsc($game['title']); ?></td>
        </tr>
      <?php } ?>
    </table>

    <?php 
      mysqli_free_result($badge_set);
    ?>

  </div>
</div>
<br>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>