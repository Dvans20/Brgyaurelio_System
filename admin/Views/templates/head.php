
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BRGY. <?php echo(ucwords($web->brgy)); ?> - Admin</title>
<link rel="icon" href="<?php echo($extLink); ?>Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?>">




<!-- loader js -->
<script src="<?php echo($extLink); ?>Views/js/loader.js<?php echo "?v" . time() . uniqid(); ?>"></script>
<!-- loader -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/libraries/spinThatShitMaster/style.css">

<!-- popperjs -->
<script src="<?php echo($extLink); ?>Views/libraries/popper.min.js"></script>

<!-- bootstrap -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/libraries/bootstrap-5.2.3-dist/css/bootstrap.min.css<?php echo "?v=" . time() . uniqid(); ?>">
<script src="<?php echo($extLink); ?>Views/libraries/bootstrap-5.2.3-dist/js/bootstrap.min.js<?php echo "?v=" . time() . uniqid(); ?>"></script>



<!-- jQuery -->
<script src="<?php echo($extLink); ?>Views/libraries/jquery.min.js<?php echo "?v=" . time() . uniqid(); ?>"></script>



<!-- style css -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/css/styles.css<?php echo "?v" . time() . uniqid(); ?>">
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/css/animation.css<?php echo "?v" . time() . uniqid(); ?>">


<!-- app js -->
<script src="<?php echo($extLink); ?>Views/js/app.js<?php echo "?v" . time() . uniqid(); ?>"></script>



<!-- scrollbar -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/css/scrollbar.css<?php echo "?v" . time() . uniqid(); ?>">

<!-- summernote -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/libraries/summernote/summernote-bs5.css<?php echo "?v" . time() . uniqid(); ?>">
<script src="<?php echo($extLink); ?>Views/libraries/summernote/summernote-bs5.js<?php echo "?v" . time() . uniqid(); ?>"></script>
<script src="<?php echo($extLink); ?>Views/libraries/summernote/lang/summernote-es-ES.js"<?php echo "?v" . time() . uniqid(); ?>></script>

<!-- cropper js -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/libraries/cropperjs/dist/cropper.min.css<?php echo( "?v=" . time() . uniqid() ); ?>">
<script src="<?php echo($extLink); ?>Views/libraries/cropperjs/dist/cropper.min.js<?php echo( "?v=" . time() . uniqid() ); ?>"></script>



<!-- chart js -->
<script src="Views/libraries/chart/chart.js<?php echo( "?v=" . time() . uniqid() ); ?>"></script>
<script src="Views/libraries/chart/chartjs_plugin_datalabels.js<?php echo( "?v=" . time() . uniqid() ); ?>"></script>
<!-- <script src="libraries/chart_label.js"></script> -->


<!-- font awesome -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/libraries/font-awesome/css/all.min.css<?php echo "?v=" . time() . uniqid(); ?>">
<!-- <script src="<?php //echo($extLink); ?>Views/libraries/font-awesome/js/all.min.js<?php echo "?v=" . time() . uniqid(); ?>"></script> -->
<!-- DataTables Bootstrap 4/5 Integration CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">