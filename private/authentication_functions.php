<?php

  // Performs all actions necessary to log in a volunteer
  function log_in_volunteer($staff) {
  // Renerating the ID protects the staff from session fixation.
    session_regenerate_id();
    $_SESSION['staff_id'] = $staff['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $staff['username'];
    $_SESSION['secretary'] = 0;
    return true;
  }
  
  // Performs all actions necessary to log in the secretary
  function log_in_secretary($staff) {
  // Renerating the ID protects the staff from session fixation.
    session_regenerate_id();
    $_SESSION['staff_id'] = $staff['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $staff['username'];
    $_SESSION['secretary'] = 1;
    return true;
  }

  // Performs all actions necessary to log out staff member
  function log_out_staff() {
    unset($_SESSION['staff_id']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);
    unset($_SESSION['secretary']);
    // session_destroy(); // optional: destroys the whole session
    return true;
  }


  // is_logged_in() contains all the logic for determining if a
  // request should be considered a "logged in" request or not.
  // It is the core of require_login() but it can also be called
  // on its own in other contexts (e.g. display one link if an staff
  // is logged in and display another link if they are not)
  function is_logged_in() {
    // Having a staff_id in the session serves a dual-purpose:
    // - Its presence indicates the staff is logged in.
    // - Its value tells which staff for looking up their record.
    return isset($_SESSION['staff_id']);
  }
  
  function is_logged_in_as_secretary() {
      // if this is 1 then the person logged in is a secretary
    return ($_SESSION['secretary'] == 1);
  }
  

  // Call require_login() at the top of any page which needs to
  // require a valid login before granting acccess to the page.
  function require_login() {
    if(!is_logged_in()) {
      redirect_to(url_for('/staff/login.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
  }
  
  function require_secretary() {
    if(!is_logged_in_as_secretary()) {
      redirect_to(url_for('/staff/Staff_Index.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
  }

?>


