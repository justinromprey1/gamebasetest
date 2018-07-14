 <?php 
  function find_all_admins(){
    //global database connection variable
    global $db;

    //MYSQL query - Select all from Admins Ordered By Last and First Name
    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";

    //make query and confirm result
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return $result;
  }

  function find_admin_by_id($id){
    //global database connection variable
    global $db;

    //MYSQL query - Obtain Admin with the given ID
    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    
    //make query and confirm result
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    //store result in $admin and return it
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($admin);
  }

  function find_admin_by_username($username){
    //global database connection variable
    global $db;

    //MYSQL query - Obtain Admin with the given username
    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' LIMIT 1";
    
    //make query and confirm result
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    //store result in $admin and return it
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ($admin);
  }

  function insert_admin($admin){
    //global database connection variable
    global $db;

    //validate admin before insertion
    $errors = validate_admin($admin);
    if (!empty($errors)){
      return $errors;
    }

    //hash pass in the database
    //password is never stored directly in the database
    $hashed_password = password_hash($admin['hashed_password'], PASSWORD_BCRYPT); 

    //MYSQL query - Insert Admin Record
    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES ('" .  db_escape($db, $admin['first_name']) . "','" . db_escape($db, $admin['last_name']) . "','" . db_escape($db, $admin['email']) . "','" . db_escape($db, $admin['username']) . "','" . db_escape($db, $hashed_password) . "');";

    //make query and confirm result
    $result = mysqli_query($db, $sql);
    if($result){
      return true;
    }else{
      //insert failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_admin($admin){
    //global database connection variable
    global $db;

    //confirm if submitted password is blank
    $password_sent = !is_blank($admin['hashed_password']);

    //validate admin before insertion
    //adding field password sent - If we used a password, password and confirm are now required
    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if (!empty($errors)){
      return $errors;
    }

    //hash pass in the database
    //password is never stored directly in the database
    $hashed_password = password_hash($admin['hashed_password'], PASSWORD_BCRYPT);

    //MYSQL query - Update admin record, given the id of the record
    $sql = "UPDATE admins SET ";
    $sql .="first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .="last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .="email='" . db_escape($db, $admin['email']) . "', ";
    if($password_sent){
      $sql .="hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .="username='" . db_escape($db, $admin['username']) . "' ";
    $sql .="WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .="LIMIT 1";

    //make query and confirm result
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

  function delete_admin($id){
    //global database connection variable
    global $db;

    //MYSQL query - Delete Admin Record, given the id of the record
    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' LIMIT 1";

    //make query and confirm result
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

  function validate_admin($admin, $options=[]) {

    //create errors array and check if password was set
    $errors = [];
    $password_required = $options['password_required'] ?? true;
  
    // first_name
    if(is_blank($admin['first_name'])) {
      $errors[] = "First Name cannot be blank.";
    }elseif(!has_length($admin['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "First Name must be between 2 and 255 characters.";
    }

    // last_name
    if(is_blank($admin['last_name'])) {
      $errors[] = "Last Name cannot be blank.";
    }elseif(!has_length($admin['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Last Name must be between 2 and 255 characters.";
    }

    // email
    if(is_blank($admin['email'])) {
      $errors[] = "Email cannot be blank.";
    }elseif(!has_length($admin['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Email must be between 2 and 255 characters.";
    }elseif(!has_valid_email_format($admin['email'])) {
      $errors[] = "Email must be in the correct format.";
    }

    // username
    $current_id = $admin['id'] ?? '0';
    if(!has_length($admin['username'], ['min' => 8, 'max' => 255])) {
      $errors[] = "Username must be between 2 and 255 characters.";
    }elseif(!is_unique_admin($admin['username'], $current_id)){
      $errors[] = "Admin must be unique.";
    }

    if($password_required){
      //password
      if(is_blank($admin['hashed_password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($admin['hashed_password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $admin['hashed_password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $admin['hashed_password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $admin['hashed_password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['hashed_password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($admin['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($admin['hashed_password'] !== $admin['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }

    }//end of password required check

    return $errors;
  }

  ?>