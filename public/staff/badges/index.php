<?php require_once('../../../private/initialize.php'); ?>

<?php
  require_login();
  $badge_set = find_all_badges();

?>

<?php $page_title = 'Badges'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="badges listing">
    <h1>Badges</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/badges/new.php'); ?>">Create New Badge</a>
      	<br>
    </div>

  	<table class="list">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Requirement</th>
        <th>Difficulty</th>
        <th>Game</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <?php while($badge = mysqli_fetch_assoc($badge_set)) { ?>
        <tr>
          <td><?php echo hsc($badge['id']); ?></td> 
          <td><?php echo hsc($badge['title']); ?></td>
          <td><?php echo hsc($badge['req']); ?></td>
          <td><?php echo hsc($badge['diff']); ?></td>
          <td><?php $game = find_game_by_id($badge['game_id']);
              echo hsc($game['title']); ?></td>
          <td><a class="action" href="<?php echo url_for('staff/badges/show.php?id='.hsc(urle($badge['id']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/badges/edit.php?id='.hsc(urle($badge['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('staff/badges/delete.php?id='. hsc(urle($badge['id']))); ?>">Delete</a></td>
        </tr>
      <?php } ?>
    </table>

    <?php 
      mysqli_free_result($badge_set);
    ?>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
