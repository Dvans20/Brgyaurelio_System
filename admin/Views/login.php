<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    
<?php 
    require_once 'templates/head.php';
?>

<link rel="stylesheet" href="Views/css/login.css<?php echo "?v" . time() . uniqid(); ?>">

</head>
<body>


    <main>


        <div class="login_container container py-5">

            <div class="card pop_in_on_scroll mt-5" data-bs-theme="dark">
                <form id="logInForm">
                    <div class="card-header d-flex">
                        <img src="Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?>" alt="Aurelio">
                        <h4 class="h3 px-2">Login to Begin</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-floating my-2">
                            <input type="text" name="email" id="email" placeholder="Email" class="form-control">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating my-2">
                            <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                            <label for="password">Password</label>
                            <div id="passwordEyeBtn">
                                <span class="fas fa-eye" id="togglepasswordEye"></span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="py-2 d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">
                                <span class="fas fa-sign-in"></span> Login
                            </button>
                        </div>
                        
                    </div>
                </form>
                
            </div>
            

        </div>

        

    </main>

    
    

    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    
</body>

<script src="Views/js/login.js<?php echo "?v" . time() . uniqid(); ?>"></script>
</html>