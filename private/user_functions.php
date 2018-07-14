<?php

function find_all_users($options = []){
    global $db;

      //create option for only getting visible subjects.
      $visible = $options['visible'] ?? false;


    //create mysql query
      $sql = "SELECT * FROM users ";
      if($visible){
        $sql .= "WHERE visible = true ";
      }
      //add to query, concatinate string
      $sql .= "ORDER BY last_name ASC, first_name ASC";

      //print sql query for troubleshooting
      //echo $sql;

      //make a query ($sql) to the database ($db) and store it in $subject_set
      $result = mysqli_query($db, $sql);

      //confirm query worked, throws an error if it didn't 
      confirm_result_set($result);

      return $result;
  }

  function find_user_by_id($id, $options=[]){
    global $db;

    //create option for only getting visible pages.
    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM users ";
    //want single quote around $ id vvv
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    if($visible) {
      $sql .= " AND visible = true";
    }
    
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($user);
  }

  function find_user_by_username($username, $options=[]){
    global $db;

    //create option for only getting visible pages.
    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM users ";
    //want single quote around $ id vvv
    $sql .= "WHERE username='" . db_escape($db, $username) . "' LIMIT 1";
    if($visible) {
      $sql .= " AND visible = true";
    }
    
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($user);
  }

  function insert_user($user){
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)){
      return $errors;
    }
    //we will hash pass
    $hashed_password = password_hash($user['hashed_password'], PASSWORD_BCRYPT); 

    //create query
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, exp, lev, username, hashed_password) ";
    $sql .= "VALUES ('" .  db_escape($db, $user['first_name']) . "','" . db_escape($db, $user['last_name']) . "','" . db_escape($db, $user['email']) . "','" . db_escape($db, $user['exp']) . "','" . db_escape($db, $user['lev']) . "','" . db_escape($db, $user['username']) . "','" . db_escape($db, $hashed_password) . "');";

    //results for inserts return true or false
    $result = mysqli_query($db, $sql);

    //check true, yes -> redirect to show page for new subject
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

  function update_user($user){
    global $db;


    $password_sent = !is_blank($user['hashed_password']);

    $errors = validate_user($user, ['password_required' => $password_sent]);
    if (!empty($errors)){
      return $errors;
    }

    //we will hash pass
    $hashed_password = password_hash($user['hashed_password'], PASSWORD_BCRYPT);

    $sql = "UPDATE users SET ";
      $sql .="first_name='" . db_escape($db, $user['first_name']) . "', ";
      $sql .="last_name='" . db_escape($db, $user['last_name']) . "', ";
      $sql .="email='" . db_escape($db, $user['email']) . "', ";
      if($password_sent){
        $sql .="hashed_password='" . db_escape($db, $hashed_password) . "', ";
      }
      $sql .="username='" . db_escape($db, $user['username']) . "' ";
      
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

  function delete_user($id){
    global $db;

    $sql = "DELETE FROM users ";
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

  function validate_user($user, $options=[]) {

    $errors = [];
    $password_required = $options['password_required'] ?? true;
  
    // first_name
    if(is_blank($user['first_name'])) {
      $errors[] = "First Name cannot be blank.";
    }elseif(!has_length($user['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "First Name must be between 2 and 255 characters.";
    }

    // last_name
    if(is_blank($user['last_name'])) {
      $errors[] = "Last Name cannot be blank.";
    }elseif(!has_length($user['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Last Name must be between 2 and 255 characters.";
    }

    // email
    if(is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    }elseif(!has_length($user['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Email must be between 2 and 255 characters.";
    }elseif(!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be in the correct format.";
    }

    // username
    $current_id = $user['id'] ?? '0';
    if(!has_length($user['username'], ['min' => 8, 'max' => 255])) {
      $errors[] = "Username must be between 2 and 255 characters.";
    }elseif(!is_unique_user($user['username'], $current_id)){
      $errors[] = "User must be unique.";
    }

    if($password_required){
    //password
    if(is_blank($user['hashed_password'])) {
      $errors[] = "Password cannot be blank.";
    } elseif (!has_length($user['hashed_password'], array('min' => 12))) {
      $errors[] = "Password must contain 12 or more characters";
    } elseif (!preg_match('/[A-Z]/', $user['hashed_password'])) {
      $errors[] = "Password must contain at least 1 uppercase letter";
    } elseif (!preg_match('/[a-z]/', $user['hashed_password'])) {
      $errors[] = "Password must contain at least 1 lowercase letter";
    } elseif (!preg_match('/[0-9]/', $user['hashed_password'])) {
      $errors[] = "Password must contain at least 1 number";
    } elseif (!preg_match('/[^A-Za-z0-9\s]/', $user['hashed_password'])) {
      $errors[] = "Password must contain at least 1 symbol";
    }

    if(is_blank($user['confirm_password'])) {
      $errors[] = "Confirm password cannot be blank.";
    } elseif ($user['hashed_password'] !== $user['confirm_password']) {
      $errors[] = "Password and confirm password must match.";
    }

    }//pass required

    return $errors;
  }

?>