<link rel="stylesheet" href="<?php echo($extLink); ?>Views/css/sidebar.css<?php echo "?v=".time().uniqid(); ?>">

<div class="sidebar_container position-relative d-block">
    <div class="sidebar">
        <nav>
            <a href="dashboard" class="dashboard d-flex">
                <div class="nav_ico">
                    <img src="<?php echo($extLink); ?>Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?><?php echo "?v=" . time(). uniqid(); ?>" alt="">
                </div>
                <h3 class="nav_text text-nowrap">
                    BRGY. Aurelio
                </h3>
            </a>
            <hr class="my-0 bg-secondary">

            <ul class="list-style-none py-2">

                
               
                <?php if ($loggedInUser->accessType != 3) { ?>
                    <li>
                        <a href="<?php echo($url); ?>rbim" class="d-flex rbim">
                            <div class="nav_ico">
                                <span class="fas fa-users"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                RBIM
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo($url); ?>rbbo" class="d-flex rbbo">
                            <div class="nav_ico">
                                <span class="fas fa-user-tie"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                RBBO
                            </div>
                        </a>
                    </li>
                   
                    <li>
                        <a href="<?php echo($url); ?>news" class="d-flex news">
                            <div class="nav_ico">
                                <span class="fas fa-newspaper"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                News & Updates
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo($url); ?>issuances" class="d-flex issuances">
                            <div class="nav_ico">
                                <span class="fas fa-gavel"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Issuances
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo($url . 'complaints'); ?>" class="d-flex complaints">
                            <div class="nav_ico">
                                <span class="fas fa-exclamation-circle"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Complaints
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo($url . 'programs'); ?>" class="d-flex programs">
                            <div class="nav_ico">
                                <span class="fas fa-cogs"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Programs
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo($url . 'violators'); ?>" class="d-flex violators">
                            <div class="nav_ico">
                                <span class="fas fa-user-times"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Offenders
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo($url . 'transactions'); ?>" class="d-flex transactions">
                            <div class="nav_ico">
                                <span class="fas fa-exchange-alt"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Transactions
                            </div>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($loggedInUser->accessType != 2) { ?>
                    <li>
                        <a href="<?php echo($url . 'payments'); ?>" class="d-flex payments">
                            <div class="nav_ico">
                                <span class="fas fa-money-bill-wave-alt"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Payments
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo($url . 'transparency'); ?>" class="d-flex transparency">
                            <div class="nav_ico">
                                <span class="fas fa-balance-scale-right"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Transparency
                            </div>
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?php echo($url); ?>certificate" class="d-flex certificate">
                        <div class="nav_ico">
                            <span class="fas fa-scroll"></span>
                        </div>
                        <div class="nav_text text-nowrap">
                            Certificates/Clearance
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo($url . 'requests'); ?>" class="d-flex requests">
                        <div class="nav_ico">
                            <span class="fas fa-clipboard-list"></span>
                        </div>
                        <div class="nav_text text-nowrap">
                            Requests
                        </div>
                    </a>
                </li>
                

                
               
                
          
        
            </ul>
            

            <?php if ($loggedInUser->accessType != 3) { ?>
                <hr class="my-0 bg-secondary">
                <ul class="list-style-none py-2">
                    <li>
                        <a href="<?php echo($url); ?>websiteSettings" class="d-flex websiteSettings">
                            <div class="nav_ico">
                                <span class="fas fa-cogs"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Website Settings
                            </div>
                        </a>
                    </li>

                </ul>
            <?php } ?>

            
            <?php if ($loggedInUser->accessType == 1) { ?>
                <hr class="my-0 bg-secondary">
                <ul class="list-style-none py-2">
                    <li>
                        <a href="<?php echo($url . 'logs'); ?>" class="d-flex logs">
                            <div class="nav_ico">
                                <span class="fas fa-history"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Activity Logs
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo($url . 'users'); ?>" class="d-flex users">
                            <div class="nav_ico">
                                <span class="fas fa-user-friends"></span>
                            </div>
                            <div class="nav_text text-nowrap">
                                Users
                            </div>
                        </a>
                    </li>
                </ul>
            <?php } ?>
        </nav>

        <!-- <div id="sidebarBtnIn" class="sidebar_btn_in">
            <span class="fas fa-angle-double-left"></span>
        </div> -->
    </div>

    <div id="sidebarBtn" class="sidebar_btn">
        <span class="fas fa-angle-double-right" id="sidebarBtnIco"></span>
    </div>
</div>

<script>
    let currentUri = "<?php echo $currentUri; ?>"

    if (currentUri == "") {
        $(document).find('a.dashboard"]').addClass('active')
    }else {
        $(document).find('a.'+currentUri).addClass('active')
    }
  

    $('#sidebarBtn, #sidebarBtnIn').click(function (e) { 
        e.preventDefault();


        if ($('.sidebar').hasClass('show')) {
            $('.sidebar, .sidebar_container').removeClass('show')
            $('#sidebarBtn').html('<span class="fas fa-angle-double-right"></span>')
            $('#sidebarBtn').removeClass('show')
            $('.body_container').removeClass('sidebar_show')
        } else {
            $('.sidebar, .sidebar_container').addClass('show')
            $('#sidebarBtn').html('<span class="fas fa-angle-double-left"></span>')
            $('#sidebarBtn').addClass('show')
            $('.body_container').addClass('sidebar_show')
        }

        
    });
</script>
