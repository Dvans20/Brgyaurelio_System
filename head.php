


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<!-- loader -->
<link rel="stylesheet" href="<?php echo($linkExt); ?>admin/Views/libraries/spinThatShitMaster/style.css">

<link rel="stylesheet" href="<?php echo($linkExt); ?>css/app.css<?php echo("?v=".time().uniqid()); ?>">


<link rel="icon" href="<?php echo($linkExt); ?>admin/Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png?v=".time().uniqid()))); ?>">

<!-- CSS FILES --> 

<!-- google fonts -->
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet"> -->
<!-- google fonts -->



<link href="<?php echo($linkExt); ?>css/bootstrap.min.css" rel="stylesheet">

<link href="<?php echo($linkExt); ?>css/bootstrap-icons.css" rel="stylesheet">

<link href="<?php echo($linkExt); ?>css/templatemo-topic-listing.css" rel="stylesheet">      

<!-- font awesome -->
<link rel="stylesheet" href="<?php echo($linkExt); ?>admin/Views/libraries/font-awesome/css/all.min.css<?php echo "?v=" . time() . uniqid(); ?>">
<script src="<?php echo($linkExt); ?>admin/Views/libraries/font-awesome/js/all.min.js<?php echo "?v=" . time() . uniqid(); ?>"></script>



<!-- scripts -->
<script src="<?php echo($linkExt); ?>js/jquery.min.js"></script>
<script src="<?php echo($linkExt); ?>js/bootstrap.bundle.min.js"></script>
<script src="<?php echo($linkExt); ?>js/jquery.sticky.js"></script>
<script src="<?php echo($linkExt); ?>js/click-scroll.js"></script>
<script src="<?php echo($linkExt); ?>js/custom.js"></script>

<script>
let showLoadingScreen = function () {

    console.log("loader")
   
    if (!document.querySelector('.loading_screen_loader')) {
        console.log("show")

        // 1. Create the new element
        var loderContainer = document.createElement('div');
                
        // 2. Add a class to the new element
        loderContainer.id = "loadingScreenLoader"
        loderContainer.classList.add('loading_screen_loader');
        
        // 1. Create the new element
        var loderElement = document.createElement('div');
            
        // 2. Add a class to the new element
        loderElement.classList.add('loader09');
        
        // 4. Find the parent element
        var parentElement = document.getElementsByTagName('html')[0];
        
        // 5. Append the new element to the parent
        loderContainer.appendChild(loderElement);

        parentElement.appendChild(loderContainer);

    }
}

let hideLoadingScreen = function() {
    let loadingScreenLoader = document.getElementById("loadingScreenLoader")

    setTimeout(() => {
        $('.loading_screen_loader').addClass('fade_out')
        setTimeout(() => {
            $('.loading_screen_loader').remove()
        }, 200);
    }, 200);
    

}

// showLoadingScreen()
</script>