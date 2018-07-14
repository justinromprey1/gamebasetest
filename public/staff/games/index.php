<?php require_once('../../../private/initialize.php'); ?>

<?php
  require_login();
  $game_set = find_all_games();

?>

<?php $page_title = 'Games'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="games listing">
    <h1>Games</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/games/new.php'); ?>">Create New Game</a>
      	<br>
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
        <th>&nbsp;</th>
        <th>&nbsp;</th>
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
          <td><a class="action" href="<?php echo url_for('/staff/games/edit.php?id='.hsc(urle($game['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('staff/games/delete.php?id='. hsc(urle($game['id']))); ?>">Delete</a></td>
        </tr>
      <?php } ?>
    </table>

    <?php 
      mysqli_free_result($game_set);
    ?>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
