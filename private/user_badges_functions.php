<?php

function get_user_badges_query($id){
    global $db;

    //create mysql query
      $sql = "SELECT user_badges.id, games.title as Game, badges.title as Title, badges.req, badges.diff, user_badges.time_complete ";
      $sql .= "FROM user_badges INNER JOIN badges ON user_badges.badge_id = badges.id ";
      $sql .= "INNER JOIN users ON user_badges.user_id = users.id ";
      $sql .= "INNER JOIN games ON badges.game_id = games.id ";
      $sql .= "WHERE users.id='" . db_escape($db, $id) . "' ";
      $sql .= "ORDER BY games.title ASC";

      //print sql query for troubleshooting
      //echo $sql;

      $result = mysqli_query($db, $sql);

      //confirm query worked, throws an error if it didn't 
      confirm_result_set($result);

      return $result;
  }

  function find_user_badge_by_id($id){
    global $db;


    $sql = "SELECT * FROM user_badges ";
    //want single quote around $ id vvv
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $user_badge = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($user_badge);
  }

  function find_user_badges_by_user_id($id){
    global $db;

    $sql = "SELECT * FROM user_badges ";
    //want single quote around $ id vvv
    $sql .= "WHERE user_id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return ($result);
  }

  function find_user_badges_by_game_id($id){
    global $db;

    $sql = "SELECT * FROM user_badges ";
    //want single quote around $ id vvv
    $sql .= "WHERE game_id='" . db_escape($db, $id) . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return ($result);
  }

  function insert_user_badge($user_badge){
    global $db;

    
    $errors = validate_user_badge($user_badge);
    if (!empty($errors)){
      return $errors;
    }

    //create query
    $sql = "INSERT INTO user_badges ";
    $sql .= "(user_id, badge_id) ";
    $sql .= "VALUES ('" . db_escape($db, $user_badge['user_id']) . "','" . db_escape($db, $user_badge['badge_id']) . "');";
    
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

  function set_badge_obtained_for_user($user_badge){
    global $db;

    $sql = "UPDATE users SET badge" . $user_badge['badge_id'] . "obtained= true ";
    $sql .= "WHERE id = '" . $user_badge['user_id'] . "' LIMIT 1";

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

  function delete_user_badge($id){
    global $db;

    $sql = "DELETE FROM user_badges ";
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

  function validate_user_badge($user_badge) {

    $errors = [];
    if(!is_unique_user_badge($user_badge)){
      $errors[] = "You already Earned this badge.";
    }

    return $errors;
  }

  function add_exp_query($user, $value){
    $newval = ($user['exp']+$value);
    global $db;

    $sql = "UPDATE users SET ";
    $sql .="exp='" . db_escape($db, $newval) . "' ";
    $sql .="WHERE id='" . db_escape($db, $user['id']) . "' ";
    $sql .="LIMIT 1";


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

  function set_level($user){
    global $db;

    $level = 1;
    if ($user['exp'] >= 500){
      $level = 2;
    }
    if ($user['exp'] >= 1000){
      $level = 3;
    }
    if ($user['exp'] >= 1500){
      $level = 4;
    }
    if ($user['exp'] >= 2000){
      $level = 5;
    }
    if ($user['exp'] >= 2500){
      $level = 6;
    }
    if ($user['exp'] >= 3000){
      $level = 7;
    }
    if ($user['exp'] >= 3500){
      $level = 8;
    }
    if ($user['exp'] >= 4000){
      $level = 9;
    }
    if ($user['exp'] >= 4500){
      $level = 10;
    }
    if ($user['exp'] >= 5000){
      $level = 11;
    }
    if ($user['exp'] >= 5500){
      $level = 12;
    }
    if ($user['exp'] >= 6000){
      $level = 13;
    }
    if ($user['exp'] >= 6500){
      $level = 14;
    }
    if ($user['exp'] >= 7000){
      $level = 15;
    }
    if ($user['exp'] >= 7500){
      $level = 16;
    }
    if ($user['exp'] >= 8000){
      $level = 17;
    }
    if ($user['exp'] >= 8500){
      $level = 18;
    }
    if ($user['exp'] >= 9000){
      $level = 19;
    }
    if ($user['exp'] >= 9500){
      $level = 20;
    }
    if ($user['exp'] >= 10000){
      $level = 21;
    }
    if ($user['exp'] >= 10500){
      $level = 22;
    }
    if ($user['exp'] >= 11000){
      $level = 23;
    }
    if ($user['exp'] >= 11500){
      $level = 24;
    }
    if ($user['exp'] >= 12000){
      $level = 25;
    }



    $sql = "UPDATE users SET ";
    $sql .="lev='" . db_escape($db, $level) . "' ";
    $sql .="WHERE id='" . db_escape($db, $user['id']) . "' ";
    $sql .="LIMIT 1";


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

?>