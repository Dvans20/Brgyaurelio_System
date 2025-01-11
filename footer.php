
<footer class="site-footer section-padding d-block">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-12 mb-4 pb-2">
                <a class="navbar-brand mb-2" href="index.php">
                    <!-- <img src="https://gwhs.i.gov.ph/gwt-footer/govph-seal-mono-footer.jpg" width="200px" alt=""> -->
                </a>
            </div>

            <div class="col-lg-3 col-md-4 col-6">
                <h6 class="site-footer-title mb-3">Republic of the Philippines</h6>

                <p class="small">
                    All content is in the public domain unless otherwise stated.
                </p>

                <!-- <ul class="site-footer-links">
                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">Home</a>
                    </li>

                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">How it works</a>
                    </li>

                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">FAQs</a>
                    </li>

                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">Contact</a>
                    </li>
                </ul> -->
            </div>

            <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                <h6 class="site-footer-title mb-3">Information</h6>

                <p class="text-white d-flex mb-1">
                    <a href="tel: <?php echo($web->contactNo); ?>" class="site-footer-link">
                        <?php echo($web->contactNo); ?>
                    </a>
                </p>

                <p class="text-white d-flex">
                    <a href="mailto:<?php echo($web->email); ?>" class="site-footer-link">
                        <?php echo($web->email); ?>
                    </a>
                </p>
            </div>

            <div class="col-lg-3 col-md-4 col-12 ms-auto">
                <!-- <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    English</button>

                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" type="button">Thai</button></li>

                        <li><button class="dropdown-item" type="button">Myanmar</button></li>

                        <li><button class="dropdown-item" type="button">Arabic</button></li>
                    </ul>
                </div> -->

                <p class="copyright-text mt-lg-3 mt-3">Copyright © 2024. All rights reserved.

                    <!--<br><br>Powered by: <a rel="nofollow" href="https://www.djemc.edu.ph/" target="_blank">DJEMC</a></p>-->

                <!-- <br><br>Design: <a rel="nofollow" href="https://templatemo.com" target="_blank">TemplateMo</a></p> -->
                
            </div>

        </div>
    </div>
</footer>
<div class="modal fade" id="msgModal">
    <div class="modal-dialog modal-sm modal-dialog-centered" id="msgModalDialog">
        <div class="modal-content" id="msgModalContent">
            
            <div class="modal-body">
                <div id="msgModalMsg" class=""></div>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm text-white" id="okMsgBtn" type="button" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" id="appLoaderModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="loader09"></div>
    </div>
</div>

<!-- JAVASCRIPT FILES -->



<script src="<?php echo($linkExt); ?>admin/Views/js/style.js<?php echo "?v=" .time() . uniqid(); ?>"></script>

<script src="<?php echo($linkExt); ?>js/app.js<?php echo "?v=" .time() . uniqid(); ?>"></script>