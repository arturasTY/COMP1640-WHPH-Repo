<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
           <div class="text-block">
                <h5 class="modal-title" id="exampleModalLongTitle">Sign In</h5>
                <p>To share, view and rank ideas.</p>
           </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="login.php" method="post">
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <span class="error">Username is required</span>
                <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@example.co.uk" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <span class="error">Password is required</span>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                <h6 class="float-right">Forgot Password?</h6>
              </div>
              <input type="submit" class="btn mybtn w-100" value="login" name="login">
            </form>
          </div>
        </div><!-- end of modal-content -->
      </div>
    </div> <!-- end of modal -->

    <div class="modal fade" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
           <div class="text-block">
                <h5 class="modal-title" id="exampleModalLongTitle">Staff Sign In</h5>
                <p>To share, view and rank ideas.</p>
           </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="staff_login.php" method="post">
              <div class="form-group">
                <label for="staffexampleInputEmail1">Username</label>
                <span class="error">Username is required</span>
                <input type="text" name="staff_username" class="form-control" id="staffexampleInputEmail1" aria-describedby="emailHelp" placeholder="name@example.co.uk" required>
              </div>
              <div class="form-group">
                <label for="staffexampleInputPassword1">Password</label>
                <span class="error">Password is required</span>
                <input type="password" name="staff_password" class="form-control" id="staffexampleInputPassword1" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="staffexampleCheck1">
                <label class="form-check-label" for="staffexampleCheck1">Remember me</label>
                <h6 class="float-right">Forgot Password?</h6>
              </div>
              <input type="submit" class="btn mybtn w-100" value="login" name="staff_login">
            </form>
          </div>
        </div><!-- end of modal-content -->
      </div>
    </div> <!-- end of modal -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-1 text-dark">
        <div class="container">
        <a href="index.php" class="navbar-brand logo"><span>W.H.P.H</span></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="ideas.php" class="nav-link">Ideas</a>
                </li>
                 <li class="nav-item">
                    <a href="faq.html" class="nav-link">FAQ</a>
                </li>

            </ul>
            <?php if(isset($_SESSION['emp_details']['username'])): ?>

            <a class="btn btn-outline cta" href="user_profile.php" ><?php echo $_SESSION['emp_details']['username']; ?></a>


            <?php else: ?>

            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter">Sign in</a>

            <?php endif; ?>
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#staffModal">Staff</a>
        </div>
        </div>
    </nav>
