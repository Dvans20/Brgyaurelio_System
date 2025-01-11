<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
?>
</head>
<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>



        <div class="container py-5">

            <div class="card pop_in_on_scroll">
                <div class="card-header p-2">
                    <div class="row m-0 p-0">
                        <div class="col-md-8 m-0 p-0">
                            <h3>
                                <span class="fas fa-question"></span> Frequently Asked Questions
                            </h3>
                        </div>
                        <div class="col-md-4 m-0 p-0">
                            <div class="w-100 d-flex justify-content-end">
                                <button class="btn btn-primary" id="addNewFaqBtn">
                                    Add Question & Answer
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">
                    
                </div>
            </div>

        </div>


    </div>





    





    <div class="modal fade" id="faqsFormModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="faqsFormModal">
                
                    <div class="modal-header">
                        <h4 class="d-flex">
                            <span class="fas fa-question-circle"></span> <div id="faqsFormModalheading" class="px-2"></div>
                        </h4>
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating my-2">
                            <input type="text" class="form-control" name="question" id="question" placeholder="Question">
                            <label for="question">Question</label>
                        </div>

                        <div class="my-2">
                            <label for="answer">Answer</label>
                            <textarea name="answer" id="answer" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="saveNewFaq" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                    </div>
                </form>
            </div>

            
        </div>
    </div>


    <?php 
        include_once 'Views/templates/foot.php';
    ?>



    <script src="Views/js/faqs.js<?php echo "?v" . time() . uniqid(); ?>"></script>

</body>
</html>