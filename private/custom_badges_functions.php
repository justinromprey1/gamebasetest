<?php

function find_all_c_badges(){
    global $db;

    //create mysql query
      $sql = "SELECT * FROM custom_badges ";
      //add to query, concatinate string
      $sql .= "ORDER BY title ASC, diff ASC";

      //print sql query for troubleshooting
      //echo $sql;

      //make a query ($sql) to the database ($db) and store it in $subject_set
      $result = mysqli_query($db, $sql);

      //confirm query worked, throws an error if it didn't 
      confirm_result_set($result);

      return $result;
  }

  function find_c_badges_by_id($id){
    global $db;


    $sql = "SELECT * FROM custom_badges ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $c_badge = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($c_badge);
  }

  function find_c_badges_by_user_id($id){
    global $db;

    $sql = "SELECT * FROM custom_badges ";
    //want single quote around $ id vvv
    $sql .= "WHERE user_id='" . db_escape($db, $id) . "' ";
    $sql .= "ORDER BY title ASC, diff ASC";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return ($result);
  }

  function insert_c_badge($c_badge){
    global $db;

    $errors = validate_c_badge($c_badge);
    if (!empty($errors)){
      return $errors;
    }

    //create query
    //ADD USER ID HERE
    $sql = "INSERT INTO custom_badges ";
    $sql .= "(title, req, diff, completed, user_id, game_id) ";
    $sql .= "VALUES ('" . db_escape($db, $c_badge['title']) . "','" . db_escape($db, $c_badge['req']) . "','" . db_escape($db, $c_badge['diff']) . "','" . db_escape($db, $c_badge['completed']) . "','" . db_escape($db, $c_badge['user_id']) . "','" . db_escape($db, $c_badge['game_id']) . "');";

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

  function update_c_badge($c_badge){
    global $db;

    $errors = validate_c_badge($c_badge);
      if (!empty($errors)){
        return $errors;
      }

    //ADD USER ID HERE
    $sql = "UPDATE custom_badges SET ";
    $sql .="title='" . db_escape($db, $c_badge['title']) . "', ";
    $sql .="req='" . db_escape($db, $c_badge['req']) . "', ";
    $sql .="diff='" . db_escape($db, $c_badge['diff']) . "', ";
    $sql .="completed='" . db_escape($db, $c_badge['completed']) . "', ";
    $sql .="game_id='" . db_escape($db, $c_badge['game_id']). "' ";
    $sql .="WHERE id='" . db_escape($db, $c_badge['id']) . "' LIMIT 1";

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

  function delete_c_badge($id){
    global $db;

    $sql = "DELETE FROM custom_badges ";
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

  function validate_c_badge($c_badge) {

    $errors = [];
  
    // menu_name
    if(is_blank($c_badge['title'])) {
      $errors[] = "Title cannot be blank.";
    }
    //menu name uniqueness check
    $current_id = $c_badge['id'] ?? '0';
    if(!name_is_unique($badge['title'], $current_id)){
      $errors[] = "Title must be Unique!";
    }
    // requirement
    if(is_blank($c_badge['req'])) {
      $errors[] = "Requirement cannot be blank.";
    }
    if(is_blank($c_badge['diff'])) {
      $errors[] = "Difficulty cannot be blank.";
    }elseif(!has_length($c_badge['diff'], ['min' => 1, 'max' => 100])) {
      $errors[] = "Difficulty must be between 1 and 100.";
    }

    return $errors;
  }

?>