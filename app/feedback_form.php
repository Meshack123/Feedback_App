<?php include 'inc/header.php'; ?>

  <?php

    function test_input($data) {
      $data = trim($data);             // Remove leading and trailing whitespace
      $data = stripslashes($data);     // Remove backslashes
      $data = htmlspecialchars($data); // Convert special characters to HTML entities
      return $data;
    }

    $msg = '';
    $class = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){

      $firstname  = $_POST['firstname'];
      $lastname  = $_POST['lastname'];
      $email  = $_POST['email'];
      $message  = $_POST['message'];

      //validate firstname
      if(empty($_POST['firstname'])){
        $msg = "Firstname is required";
        $class = "alert-danger";
      }else{
        $firstname = test_input($_POST['firstname']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
          $msg = "Firstname required Only letters and white space allowed";
          $class = "alert-danger";
            
        }
      }

      //validate lastname
      if(empty($_POST['lastname'])){
        $msg = "lastname is required";
        $class = "alert-danger";
      }else{
        $lastname = test_input($_POST['lastname']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
          $msg = "Lastname required Only letters and white space allowed";
          $class = "alert-danger";
            
        }
      }

      //validate lastname
      if(empty($_POST['email'])){
        $msg = "Email is required";
        $class = "alert-danger";
      }else{
        $email = test_input($_POST['email']);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $msg = "Invalid Email format";
          $class = "alert-danger"; 
        }
      }

      //validate message
      if(empty($_POST['message'])){
        $msg = "message is required";
        $class = "alert-danger";
      }

      //check if all the field required is empty else add to the database
      if(empty($firstname) && empty($lastname) && empty($email) && empty($message)){
        //Failed msg for empty field
        $msg = "All this field are Empty";
        $class = "alert-danger";
      }else{
        // Insert data into the database using prepared statements
        $sql = "INSERT INTO feedback (firstname, lastname, email, message) VALUES (?, ?, ?, ?)";
        //die($sql);

        $stmt = mysqli_prepare($conn, $sql);

        if($stmt){
          mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $message);

          if(mysqli_stmt_execute($stmt)){
            // Success
            $msg = "Successfully inserted into the Feedback";
            $class = "alert-success";

            //header('Location: output.php');
          }else{
            // Failed
            $msg = "Error inserting into the database: " . mysqli_error($conn);
            $class = "alert-danger";
          }

          mysqli_stmt_close($stmt);
        }
      }
    }
    
              
  ?>


        <div class="search-bar">
          <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
          </form>
        </div><!-- End Search Bar -->

        <i class="bi bi-list toggle-sidebar-btn d-sm-block d-lg-none"></i>
    
        <nav class="header-nav ms-auto me-3">
          <ul class="d-flex align-items-center">
    
            <li class="nav-item d-block d-lg-none">
              <a class="nav-link nav-icon search-bar-toggle  text-light" href="#">
                <i class="bi bi-search"></i>
              </a>
            </li><!-- End Search Icon-->

            <li class="nav-item ">
                <a class="nav-link nav-icon search-bar-toggle  text-light" href="feedback_form.php">
                  Home
                </a>
            </li><!-- End Home Icon-->

            <li class="nav-item ">
                <a class="nav-link nav-icon search-bar-toggle  text-light " href="#">
                  About
                </a>
            </li><!-- End Home Icon--> 

            <li class="nav-item ">
                <a class="nav-link nav-icon search-bar-toggle  text-light " href="output.php">
                  FeedBack
                </a>
            </li><!-- End Home Icon-->
          </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->

    <section class="feedback_form">
        <div class="container">

            <div class="d-flex align-items-center">
                <a href="index.html" class="brand-logo d-flex align-items-center">
                  <img src="/feedback/assets/img/IMG_5497.PNG" alt="">
                </a>
            </div><!-- End Logo -->
            <p class="lead text-center fw-semibold" style="color:#2435A1;">Customer FeedBack </p>
            <p class="pb-3 text-center fw-semibold ;">Leave feedback for instagram</p>

            <div class="mb-5">

            <?php if($msg):?>
              <div class="alert <?php echo $class ; ?>"><?php  echo $msg; ?></div>
            <?php endif; ?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form" class="php-email-form">
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="text" name="firstname" class="form-control" id="name" placeholder="FirstName" >
                  </div>
                  <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input type="text" name="lastname" class="form-control" id="name" placeholder="LastName">
                    
                  </div>
                </div>
                <div class="form-group mt-3">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                </div>
                <div class="form-group mt-3">
                  <textarea class="form-control" name="message" rows="5" placeholder="Enter Your Feedback"></textarea>
                </div>
                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit" name="taken" value="submit">Send Message</button></div>
              </form>
            </div>
        </div>
    </section>

<?php include 'inc/footer.php'; ?>