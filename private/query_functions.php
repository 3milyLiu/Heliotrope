<?php

// This is where all functions for database queries will go, searching, inserting, deleting, updating etc


/**
 * ---------------------------Rules queries---------------------------
 */

// get rules
function get_rules() {
    global $db;
    
    $sql = "SELECT * FROM rules ";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return mysqli_fetch_array($result);
}


function update_rules($rules) {
    global $db;
    
    $sql = "UPDATE rules SET ";
    $sql .= "rental_length='+" . db_escape($db, $rules['rental_length']) . " weeks', ";
    $sql .= "max_rentals='" . db_escape($db, $rules['max_rentals']) . "', ";
    $sql .= "ban_length='+" . db_escape($db, $rules['ban_length']) . " months', ";
    $sql .= "extension_length='+" . db_escape($db, $rules['extension_length']) . " weeks', ";
    $sql .= "max_extensions='" . db_escape($db, $rules['max_extensions']) . "', ";
    $sql .= "max_violations='" . db_escape($db, $rules['max_violations']) . "' ";
    $sql .= "WHERE rules_id=1 ";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
}

/**
 * ---------------------------Game queries---------------------------
 */

function find_all_games() {
    global $db;

    $sql = "SELECT * FROM games ";
    $sql .= "ORDER BY game_id ASC";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

function find_game_by_id($id) {
    global $db;

    $sql = "SELECT * FROM games ";
    $sql .= "WHERE game_id='" . db_escape($db, $id) . "'";
    // echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $game = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $game; 
  }
  
  function find_game_by_title($input) {
    global $db;
    
    if($input == "")
        return find_all_games();

    $sql = "SELECT * FROM games ";
    $sql .= "WHERE title LIKE '%" . db_escape($db, $input) . "%'";
    $sql .= " OR platform LIKE '%" . db_escape($db, $input) . "%'";
    $sql .= " OR release_year LIKE '%" . db_escape($db, $input) . "%'";
    // echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; 
  }
  
  // check that a game is not broken and avialable
function game_is_available($id) {
    $game = find_game_by_id($id);
    
    return ($game['available'] == 1 && $game['broken'] == 0);
  }
  
  // change the availability of a game
function change_game_availability($id) {
      $game = find_game_by_id($id);
      
      if($game['available'] == 1) { // if available, make not avaialabe
          $game['available'] = 0;
      } else { // game is not available, make it available again
          $game['available'] = 1;
      }
      // update the
      update_game($game);
  }

    //checks for valid game input
function validate_game($game) {
    $errors = [];

    // game title
    if(is_blank($game['title'])) {
      $errors[] = "Title cannot be blank.";
    } elseif(!has_length($game['title'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Title must be between 2 and 255 characters.";
    }

    // release year
    $date = (int) $game['release_year'];
    if($date < 1990 || $date > (int)date("Y")) {
      $errors[] = "Year must be between 1990 and ". date("Y");
    }
    
    // game price
    if(is_blank($game['price'])) {
      $errors[] = "Price cannot be blank.";
    } elseif(!has_length($game['price'], ['min' => 2, 'max' => 6])) {
      $errors[] = "Price must be a number between 0.00 and 999.99.";
    }

    return $errors;
  }
  
  
function update_game($game) {
    global $db;

    $errors = validate_game($game);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE games SET ";
    $sql .= "title='" . db_escape($db, $game['title']) . "', ";
    $sql .= "platform='" . db_escape($db, $game['platform']) . "', ";
    $sql .= "release_year='" . db_escape($db, $game['release_year']) . "', ";
    $sql .= "price='" . db_escape($db, $game['price']) . "', ";
    $sql .= "broken='" . db_escape($db, $game['broken']) . "', ";
    $sql .= "available='" . db_escape($db, $game['available']) . "', ";
    $sql .= "info='" . db_escape($db, $game['info']) . "', ";
    $sql .= "image='" . db_escape($db, $game['image']) . "' ";
    $sql .= "WHERE game_id='" . db_escape($db, $game['game_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }
  
function insert_game($game) {
    global $db;

    $errors = validate_game($game);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO games ";
    $sql .= "(title, platform, release_year, broken, available, price, info, image) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $game['title']) . "',";
    $sql .= "'" . db_escape($db, $game['platform']) . "', ";
    $sql .= "'" . db_escape($db, $game['release_year']) . "', ";
    $sql .= "'" . db_escape($db, $game['broken']) . "',";
    $sql .= "'" . db_escape($db, $game['available']) . "', ";
    $sql .= "'" . db_escape($db, $game['price']) . "', ";
    $sql .= "'" . db_escape($db, $game['info']) . "', ";
    $sql .= "'" . db_escape($db, $game['image']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo $sql. "<br>";
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  
function delete_game($id) {
    global $db;

    $sql = "DELETE FROM games ";
    $sql .= "WHERE game_id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  
/**
 * ---------------------------Platform queries---------------------------
 */
  
function find_all_platforms() {
    global $db;

    $sql = "SELECT * FROM platform ";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
/**
 * ---------------------------Rental queries---------------------------
 */
  
// find all rentals and the associated game and member data
function find_all_rentals() {
    global $db;

    // combines the rentals with the respective game and member detials
    $sql = "SELECT * FROM rentals NATURAL JOIN games NATURAL JOIN members ";
    $sql .= "ORDER BY date_due DESC";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
function find_all_current_rentals() {
    global $db;

    // combines the rentals with the respective game and member detials
    $sql = "SELECT * FROM rentals NATURAL JOIN games NATURAL JOIN members ";
    $sql .= "WHERE returned = 0 ";
    $sql .= "ORDER BY date_due DESC";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
function find_all_overdue_rentals() {
    global $db;

    // combines the rentals with the respective game and member detials
    $sql = "SELECT * FROM rentals NATURAL JOIN games NATURAL JOIN members ";
    $sql .= "WHERE date_due < NOW() AND returned = 0 ";
    $sql .= "ORDER BY rental_id DESC";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
  
// find a rental that we know the member_id, game_id and date_rented
function find_rental_by_id($rental) {
    global $db;

    // combines the rentals with the respective game and member detials
    $sql = "SELECT * FROM rentals NATURAL JOIN games NATURAL JOIN members ";
    $sql .= "WHERE rental_id='". db_escape($db, $rental['rental_id']). "' ";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
// if a member has a certian amount of rentals then they can make no more
// until a game has been returned
function member_is_at_rental_limit($id) {
      global $db;
      
      $rules = get_rules();

      $sql = "SELECT * FROM rentals ";
      $sql .= "WHERE member_id='". db_escape($db, $id). "' AND returned='". db_escape($db, $rules['max_rentals'])."'";
      //echo $sql; // for debugging
      $result = mysqli_query($db, $sql);
      confirm_result_set($result);
      $count = mysqli_num_rows($result);
      return $count == $rules['max_extensions'];
  }
  
// check that rental is poosible 
function validate_rental($rental) {
    global $db;
    
    $errors = [];

    $member = find_member_by_id($rental['member_id']);
    $game = find_game_by_id($rental['game_id']);
    // check member exsists
    if(count($member) == 0) {
        $errors[] = "Member ID not recognised.";
    } else {
        // check if the member is banned
        if($member['ban_status'] == 1) {
            $errors[] = "Member is currently banned.";
        }
        // check if they can make more rentals
        if(member_is_at_rental_limit($rental['member_id'])) {
            $errors[] = "Member is at the rentals limit";
        }
    }
    if(count($game) == 0) {
        $errors[] = "Game ID not recognised.";
    } else {
        if(!game_is_available($rental['game_id'])) {
            $errors[] = "Game is currently unavailable";
        }
    }


    return $errors;
  }
  
// insert a new rental
function insert_rental($rental) {
    global $db;
    
    $rules = get_rules();
    // set the rental length from the rules
    $rental['date_due'] = date('Y-m-d', strtotime($rules['rental_length']));
    
    $errors = validate_rental($rental);
    if(!empty($errors)) {
      return $errors;
    }
    
    $sql = "INSERT INTO rentals ";
    $sql .= "(member_id, game_id, date_rented, date_due, extensions, returned) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $rental['member_id']) . "',";
    $sql .= "'" . db_escape($db, $rental['game_id']) . "',";
    $sql .= "'" . db_escape($db, $rental['date_rented']) . "',";
    $sql .= "'" . db_escape($db, $rental['date_due']) . "',";
    $sql .= "'" . db_escape($db, $rental['extensions']) . "',";
    $sql .= "'" . db_escape($db, $rental['returned']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
        // rental successful, set game to unavailable
        change_game_availability($rental['game_id']);
        return true;
    } else {
      // INSERT failed
      echo $sql. "<br>";
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  
// change the due date of a rental
function extend_rental($id) {
      global $db;
      
      $rules = get_rules();
      $rental = mysqli_fetch_assoc(find_rental_by_id($id));
      $errors = [];
      
      if($rental['extensions'] == $rules['max_extensions']) {
          $errors[] = "This rental already has the maximum number of extensions.";
          return $errors;
      } else {
          $sql = "UPDATE rentals SET ";
          $sql .= "extensions=extensions+1, ";
          // convert the date in the db to php usable date and extend.
          $date_due = strtotime($rental['date_due']);
          $new_due_date = date("Y-m-d", strtotime($rules['extension_length'], $date_due));
          // place the new due date in the database
          $sql .= "date_due='". db_escape($db, $new_due_date) ."' ";
          $sql .= "WHERE rental_id='" . db_escape($db, $rental['rental_id']) . "' ";
          $sql .= "LIMIT 1";
            
          $result = mysqli_query($db, $sql);
          // For UPDATE statements, $result is true/false
          if($result) {
              return true;
            } else {
              // UPDATE failed
              echo mysqli_error($db);
              db_disconnect($db);
              exit;
            }
      }
  }

  
function rental_returned_broken($id) {
      global $db;
      
      $rental = mysqli_fetch_assoc(find_rental_by_id($id));
      
      $game = find_game_by_id($rental['game_id']);
      // update the game to be broken
      $game['broken'] = 1;
      update_game($game);
      
      return_rental($id);
      // add the cost of the game to the members fine and bad them
      return add_member_fine($rental['member_id'], $game['price']);
  }
  
function return_rental($id) {
    global $db;
      
    $rental = mysqli_fetch_assoc(find_rental_by_id($id));
      
    change_game_availability($rental['game_id']);
      
    $sql = "UPDATE rentals SET ";
    $sql .= "returned=1 ";
    $sql .= "WHERE rental_id='" . db_escape($db, $rental['rental_id']) . "' ";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
         return true;
    } else {
         // UPDATE failed
         echo mysqli_error($db);
         db_disconnect($db);
         exit;
    }
  }
  
  
  
/**
 * ---------------------------Member queries---------------------------
 */

function add_member_violation($id) {
    global $db;
      
    $rules = get_rules();
    $member = mysqli_fetch_assoc(get_member_by_id($id));
    $member['violations'] += 1;
      
      
    $sql = "UPDATE members SET ";
    // max violations reached, reset and banned
    if($member['violations'] == $rules['max_violations']) { 
        $sql .= "violations=0, ";
        $sql .= "ban_status=1 ";
        // TODO: add ban_end_date to member. for when ban_end_date is added to member:
//        $sql .= "violations=0, ";
//        $sql .= "ban_status=1, ";
//        $sql .= "ban_end_date='". date('Y-m-d', strtotime($rules['ban_length'])). "' ";
    } else {
        $sql .= "violations=violations+'". $member['violations']. "' ";    
    }
    $sql .= "WHERE member_id='" . db_escape($db, $member) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
  }
  
// add the price of the game to pending fine and ban this member.
function add_member_fine($member, $price) {
    global $db;

    $sql = "UPDATE members SET ";
    $sql .= "ban_status=1, ";
    $sql .= "pending_fine=pending_fine+'" . db_escape($db, $price) . "' ";
    $sql .= "WHERE member_id='" . db_escape($db, $member) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
    
function get_all_members() {
    global $db;
    $sql = "SELECT * FROM members ";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
function get_all_banned_members() {
    global $db;
    $sql = "SELECT * FROM members WHERE ban_status=1";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function get_members_with_fees() {
    global $db;
    $sql = "SELECT * FROM members WHERE pending_fine>0";
    //echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}
  
function find_member_by_id($id) {
    global $db;
    $sql = "SELECT * FROM members ";
    $sql .= "WHERE member_id='" . db_escape($db, $id) . "'";
    // echo $sql; // for debugging
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $member = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $member; 
  }
  
// member validation 
function validate_member($member) {
    $errors = [];
    //Members first name.
    if(is_blank($member['name'])) {
      $errors[] = "Each member requires a first name.";
    } elseif(!has_length($member['name'], ['min' => 2, 'max' => 20])) {
      $errors[] = "A first name can range from two to twenty characters.";
    }
    //Members last name.
    if(is_blank($member['surname'])) {
      $errors[] = "Each member requires a last name.";
    } elseif(!has_length($member['name'], ['min' => 2, 'max' => 20])) {
      $errors[] = "A last name can range from two to twenty characters.";
    }
    return $errors;
  }

function insert_member($member) {
    global $db;

    $errors = validate_member($member);
    if(!empty($errors)) {
      return $errors;
    }
    $sql = "INSERT INTO members ";
    $sql .= "(name, surname, pending_fine, ban_status, violations) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $member['name']) . "',";
    $sql .= "'" . db_escape($db, $member['surname']) . "',";
    $sql .= "'" . db_escape($db, $member['pending_fine']) . "',";
    $sql .= "'" . db_escape($db, $member['ban_status']) . "',";
    $sql .= "'" . db_escape($db, $member['violations']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
        return true;
    } else {
      // INSERT failed
      echo $sql. "<br>";
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  
function update_member($member) {
    global $db;
    $errors = validate_member($member);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE members SET ";
    $sql .= "name='" . db_escape($db, $member['name']) . "', ";
    $sql .= "surname='" . db_escape($db, $member['surname']) . "', ";
    $sql .= "ban_status='" . db_escape($db, $member['ban_status']) . "' ";
    $sql .= "WHERE member_id='" . db_escape($db, $member['member_id']) . "'";
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
function delete_member($id) {
    global $db;
    $sql = "DELETE FROM members ";
    $sql .= "WHERE member_id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  
function find_by_username($username) {
    global $db;
    
    $sql = "SELECT * FROM staff ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result); 
    mysqli_free_result($result);
    return $user; 
  }

function find_by_staff($username) {
    global $db;
    $sql = "SELECT * FROM staff";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result); 
    mysqli_free_result($result);
    return $user; 
  }
  
/**
 * ---------------------------Staff queries---------------------------
 */

  
function find_all_staff() {
    global $db;

    $sql = "SELECT * FROM staff ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

function find_staff_by_id($id) {
    global $db;

    $sql = "SELECT * FROM staff ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $staff = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $staff; // returns an assoc. array
  }

function find_staff_by_username($username) {
    global $db;

    $sql = "SELECT * FROM staff ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $staff = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $staff; // returns an assoc. array
  }

function validate_staff($staff, $options=[]) {

    $password_required = $options['password_required'] ?? true;

    if(is_blank($staff['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($staff['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($staff['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($staff['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($staff['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($staff['email'], array('max' => 255))) {
      $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($staff['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if(is_blank($staff['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($staff['username'], array('min' => 8, 'max' => 255))) {
      $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($staff['username'], $staff['id'] ?? 0)) {
      $errors[] = "Username not allowed. Try another.";
    }

    if($password_required) {
      if(is_blank($staff['password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($staff['password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $staff['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $staff['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $staff['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $staff['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($staff['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($staff['password'] !== $staff['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }
    }
    
    return $errors;
  }

function insert_staff($staff) {
    global $db;

    $errors = validate_staff($staff);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($staff['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO staff ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $staff['first_name']) . "',";
    $sql .= "'" . db_escape($db, $staff['last_name']) . "',";
    $sql .= "'" . db_escape($db, $staff['email']) . "',";
    $sql .= "'" . db_escape($db, $staff['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

function update_staff($staff) {
    global $db;

    $password_sent = !is_blank($staff['password']);

    $errors = validate_staff($staff, ['password_required' => $password_sent]);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($staff['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE staff SET ";
    $sql .= "first_name='" . db_escape($db, $staff['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $staff['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $staff['email']) . "', ";
    if($password_sent) {
      $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $staff['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $staff['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

function delete_staff($staff) {
    global $db;

    $sql = "DELETE FROM staff ";
    $sql .= "WHERE id='" . db_escape($db, $staff['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
?>
