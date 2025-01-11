
<style>
    .navbar .header_logo {
        width: 35px;
        height: auto;
    }
</style>


<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-uppercase text-white" href="<?php echo $web->siteUrl; ?>">
            <!-- <i class="bi-back"></i> -->
                <img src="<?php echo($web->siteUrl); ?>/admin/Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?>" alt="<?php echo($web->brgy); ?>" class="header_logo">
            <span>BRGY. <?php echo($web->brgy); ?></span>
        </a>

        <!-- <div class="d-lg-none ms-auto me-4">
            <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
        </div> -->

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-5 me-lg-auto">
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="<?php echo $web->siteUrl; ?>home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="<?php echo $web->siteUrl; ?>about">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="<?php echo $web->siteUrl; ?>news">News & Updates</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="<?php echo $web->siteUrl; ?>/transparencies">Transparency</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="<?php echo $web->siteUrl; ?>/resolutions">Issuances</a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link text-nowrap" href="#section_5">Contact</a>
                </li> -->

                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="topics-listing.html">Topics Listing</a></li>

                        <li><a class="dropdown-item" href="contact.html">Contact Form</a></li>
                    </ul>
                </li> -->
            </ul>

            <!-- <div class="d-none d-lg-block">
                <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
            </div> -->
        </div>
    </div>
</nav>