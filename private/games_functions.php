<?php

function find_all_games(){
    global $db;

    //create mysql query
      $sql = "SELECT * FROM games ";
      //add to query, concatinate string
      $sql .= "ORDER BY title ASC, system ASC";

      //print sql query for troubleshooting
      //echo $sql;

      //make a query ($sql) to the database ($db) and store it in $subject_set
      $result = mysqli_query($db, $sql);

      //confirm query worked, throws an error if it didn't 
      confirm_result_set($result);

      return $result;
  }

  function find_game_by_id($id){
    global $db;


    $sql = "SELECT * FROM games ";
    //want single quote around $ id vvv
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $game = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($game);
  }

  function insert_game($game){
    global $db;

    $errors = validate_game($game);
    if (!empty($errors)){
      return $errors;
    }

    //create query
    $sql = "INSERT INTO games ";
    $sql .= "(title, system, dev, pub, genre, year, release_date) ";
    $sql .= "VALUES ('" . db_escape($db, $game['title']) . "','" . db_escape($db, $game['system']) . "','" . db_escape($db, $game['dev']) . "','" . db_escape($db, $game['pub']) . "','". db_escape($db, $game['genre']) . "','". db_escape($db, $game['year']) . "','". db_escape($db, $game['release_date']) . "');";

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

  function update_game($game){
    global $db;

    $errors = validate_game($game);
      if (!empty($errors)){
        return $errors;
      }

    $sql = "UPDATE games SET ";
    $sql .="title='" . db_escape($db, $game['title']) . "', ";
    $sql .="system='" . db_escape($db, $game['system']) . "', ";
    $sql .="dev='" . db_escape($db, $game['dev']) . "', ";
    $sql .="pub='" . db_escape($db, $game['pub']) . "', ";
    $sql .="genre='" . db_escape($db, $game['genre']) . "', ";
    $sql .="year='" . db_escape($db, $game['year']) . "', ";
    $sql .="release_date='" . db_escape($db, $game['release_date']) . "' ";
    $sql .="WHERE id='" . db_escape($db, $game['id']) . "' LIMIT 1";

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

  function delete_game($id){
    global $db;

    $sql = "DELETE FROM games ";
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

  function validate_game($game) {

    $errors = [];
  
    // menu_name
    if(is_blank($game['title'])) {
      $errors[] = "Title cannot be blank.";
    }
    //menu name uniqueness check
    $current_id = $game['id'] ?? '0';
    if(!name_is_unique($game['title'], $current_id)){
      $errors[] = "Title must be Unique!";
    }

    return $errors;
  }

?>