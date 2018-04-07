<nav class="navbar navbar-expand-lg navbar-dark bg-dark-1 text-dark" style="box-shadow: none;">
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
                    <a href="submit_idea.php" class="nav-link outline">Submit idea</a>
                </li>
            </ul>
            
            <?php if(isset($_SESSION['emp_details']['username'])): ?>
            
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter"><?php echo $_SESSION['emp_details']['username']; ?></a>

            
            <?php else: ?>
            
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter">Sign in</a>
            
            <?php endif; ?>
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter">Staff</a>
        </div>
        </div>
    </nav> <!--end of main nav -->