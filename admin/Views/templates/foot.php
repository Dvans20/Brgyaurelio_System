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

<script>
    let currentDate = new Date('<?php echo(date('Y-m-d')); ?>')
</script>

<script src="<?php echo($extLink); ?>Views/js/style.js<?php echo "?v=" .time() . uniqid(); ?>"></script>