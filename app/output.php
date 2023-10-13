<?php include 'inc/header.php'; ?>

    <?php
    $sql = 'SELECT * FROM feedback';
    $result = mysqli_query($conn, $sql);
    $feedback= mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                <a class="nav-link nav-icon search-bar-toggle  text-light " href="">
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

           
            <p class="lead text-center fw-semibold pb-5" style="color:#2435A1;">Customer FeedBack</p>

            <?php if(empty($feedback)): ?>
                <p class="text-center ">There is no Feedback</p>
            <?php endif; ?>

            <?php foreach($feedback as $item):?>
                <div class="card my-3 feedback_block">
                    <div class="card-body text-center">
                       <p class="fw-semibold"><?php echo $item['message']; ?></p>
                        <div class="text-secondary pt-2">
                            By <?php echo $item['firstname'] . ' ' . $item['lastname']?> on <?php echo $item['created_date']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <p></p>
        </div>
    </section>


    <?php include 'inc/footer.php'; ?>