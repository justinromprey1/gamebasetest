<?php

function find_all_badges(){
    global $db;

    //create mysql query
      $sql = "SELECT * FROM badges ";
      //add to query, concatinate string
      $sql .= "ORDER BY game_id ASC, title ASC";

      //print sql query for troubleshooting
      //echo $sql;

      //make a query ($sql) to the database ($db) and store it in $subject_set
      $result = mysqli_query($db, $sql);

      //confirm query worked, throws an error if it didn't 
      confirm_result_set($result);

      return $result;
  }

  function find_badges_by_id($id){
    global $db;


    $sql = "SELECT * FROM badges ";
    //want single quote around $ id vvv
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $badge = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($badge);
  }

  function insert_badge($badge){
    global $db;

    $errors = validate_badge($badge);
    if (!empty($errors)){
      return $errors;
    }

    //create query
    $sql = "INSERT INTO badges ";
    $sql .= "(title, req, diff, game_id) ";
    $sql .= "VALUES ('" . db_escape($db, $badge['title']) . "','" . db_escape($db, $badge['req']) . "','" . db_escape($db, $badge['diff']) . "','" . db_escape($db, $badge['game_id']) . "');";

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

  function create_user_badge_check_query($id){
    global $db;
    $sql = "ALTER TABLE users ADD COLUMN badge". $id . "obtained BOOLEAN DEFAULT false";

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

  function update_badge($badge){
    global $db;

    $errors = validate_badge($badge);
      if (!empty($errors)){
        return $errors;
      }

    $sql = "UPDATE badges SET ";
    $sql .="title='" . db_escape($db, $badge['title']) . "', ";
    $sql .="req='" . db_escape($db, $badge['req']) . "', ";
    $sql .="diff='" . db_escape($db, $badge['diff']) . "', ";
    $sql .="game_id='" . db_escape($db, $badge['game_id']). "' ";
    $sql .="WHERE id='" . db_escape($db, $badge['id']) . "' LIMIT 1";

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

  function delete_badge($id){
    global $db;

    $sql = "DELETE FROM badges ";
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

  function validate_badge($badge) {

    $errors = [];
  
    // menu_name
    if(is_blank($badge['title'])) {
      $errors[] = "Title cannot be blank.";
    }
    //menu name uniqueness check
    $current_id = $badge['id'] ?? '0';
    if(!name_is_unique($badge['title'], $current_id)){
      $errors[] = "Title must be Unique!";
    }
    // requirement
    if(is_blank($badge['req'])) {
      $errors[] = "Requirement cannot be blank.";
    }

    return $errors;
  }

?>