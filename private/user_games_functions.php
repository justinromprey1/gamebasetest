<?php

function get_user_games_query($id){
    global $db;

    //create mysql query
      $sql = "SELECT user_games.id, games.title, games.system, games.dev, games.pub, games.genre, games.year, user_games.time_input, user_games.completed, user_games.format, user_games.user_rating, user_games.status ";
      $sql .= "FROM user_games INNER JOIN games ON user_games.game_id = games.id ";
      $sql .= "INNER JOIN users ON user_games.user_id = users.id ";
      $sql .= "WHERE users.id='" . db_escape($db, $id) . "' ";
      $sql .= "ORDER BY games.title ASC";

      //print sql query for troubleshooting
      //echo $sql;

      $result = mysqli_query($db, $sql);

      //confirm query worked, throws an error if it didn't 
      confirm_result_set($result);

      return $result;
  }

  function find_user_game_by_id($id){
    global $db;


    $sql = "SELECT * FROM user_games ";
    //want single quote around $ id vvv
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $user_game = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($user_game);
  }

  function find_user_game_by_user_id($id){
    global $db;

    $sql = "SELECT * FROM user_games ";
    //want single quote around $ id vvv
    $sql .= "WHERE user_id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return ($result);
  }

  function find_user_game_by_game_id($id){
    global $db;

    $sql = "SELECT * FROM user_games ";
    //want single quote around $ id vvv
    $sql .= "WHERE game_id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return ($result);
  }

  function insert_user_game($user_game){
    global $db;

    

    //create query
    $sql = "INSERT INTO user_games ";
    $sql .= "(completed, format, user_rating, user_id, game_id, status) ";
    $sql .= "VALUES ('" . db_escape($db, $user_game['completed']) . "','" . db_escape($db, $user_game['format']) . "','" . db_escape($db, $user_game['user_rating']) . "','" . db_escape($db, $user_game['user_id']) . "','". db_escape($db, $user_game['game_id']) . "','". db_escape($db, $user_game['status']) . "');";

    //results for inserts return true or false
    $result = mysqli_query($db, $sql);

    //check true, yes -> redirect to show page for new page
    //if no, call error and disconnect from database
    if($result){
      return true;
    }else{
      //insert failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_user_game($user_game){
    global $db;

    $sql = "UPDATE user_games SET ";
    $sql .="completed='" . db_escape($db, $user_game['completed']) . "', ";
    $sql .="format='" . db_escape($db, $user_game['format']) . "', ";
    $sql .="user_rating='" . db_escape($db, $user_game['user_rating']) . "', ";
    $sql .="user_id='" . db_escape($db, $user_game['user_id']) . "', ";
    $sql .="game_id='" . db_escape($db, $user_game['game_id']) . "', ";
    $sql .="status='" . db_escape($db, $user_game['status']) . "' ";
    $sql .="WHERE id='" . db_escape($db, $user_game['id']) . "' LIMIT 1";

    $result = mysqli_query($db, $sql);
    if($result){
        return true;
    }else{
        //update failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
  }

  function delete_user_game($id){
    global $db;

    $sql = "DELETE FROM user_games ";
      $sql .= "WHERE id='" . db_escape($db, $id) . "' LIMIT 1";

      $result = mysqli_query($db, $sql);
      if(result){
          return true;
      }else{
          //update failed
          echo mysqli_error($db);
          db_disconnect($db);
          exit;
      }
  }

  function validate_user_game($user_game) {

    $errors = [];
  
    // menu_name
    if(is_blank($user_game['title'])) {
      $errors[] = "Title cannot be blank.";
    }
    //menu name uniqueness check
    $current_id = $user_game['id'] ?? '0';
    if(!name_is_unique($user_game['title'], $current_id)){
      $errors[] = "Title must be Unique!";
    }

    return $errors;
  }

?>