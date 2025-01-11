const msgModal = document.getElementById('msgModal')
const msgModalBS = new bootstrap.Modal(msgModal)



msgModal.addEventListener('hidden.bs.modal', function () {
    if ($('#msgModalDialog').hasClass('shake_in')) {
        $('#msgModalDialog').removeClass('shake_in')
    }

    if ($('#msgModalContent').hasClass('bg-warning')) {
        $('#msgModalContent').removeClass('bg-warning')
    }

    if ($('#msgModalContent').hasClass('bg-danger')) {
        $('#msgModalContent').removeClass('bg-danger')
        $('#msgModalContent').removeClass('text-white')
    }

    if ($('#msgModalMsg').hasClass('text-danger')) {
        $('#msgModalMsg').removeClass('text-danger')
    }

    if ($('#msgModalContent').hasClass('bg-success')) {
        $('#msgModalContent').removeClass('bg-success')
        $('#msgModalContent').removeClass('text-white')
    }

    if ($('#msgModalContent').hasClass('bg-info')) {
        $('#msgModalContent').removeClass('bg-info')
        $('#okMsgBtn').removeClass('btn-primary')
    }

   

    $('#okMsgBtn').removeClass('btn-danger')
    

    $('#msgModalMsg').html("")
})

function displayMsg(status, msg) {

    // 1 = error
    // 2 = warning
    // 3 = success
    // 4 = info

    if (status == 1) {
        $('#msgModalDialog').addClass('shake_in')
        $('#msgModalContent').addClass('bg-danger')
        $('#msgModalContent').addClass('text-warning')
        $('#okMsgBtn').addClass('btn-warning')
    } else if (status == 2) {
        $('#msgModalDialog').addClass('shake_in')
        $('#msgModalContent').addClass('bg-warning')
        $('#msgModalMsg').addClass('text-danger')
        $('#okMsgBtn').addClass('btn-danger')
    } else if (status == 3) {
        $('#msgModalContent').addClass('bg-success')
        $('#msgModalContent').addClass('text-white')
    } else if (status == 4) {
        $('#msgModalContent').addClass('bg-info')
        $('#msgModalContent').addClass('text-dark')
        $('#okMsgBtn').addClass('btn-primary')
    }

    if (status == 1 && status == 2) {
        $('#msgModalMsg').addClass("shake_in")
    } else {
        $('#msgModalMsg').removeClass("shake_in")
    }
    

    $('#msgModalMsg').html(msg)

    msgModalBS.show()

    
}

function displayTableMsg(elementId, colspan, msg) {

    let col = '<td colspan="'+colspan+'" class="text-center text-muted py-5 shake_in"><div="text-center w-100 d-block">'+msg+'</div></td>';

    let row = '<tr class="">'+col+'</tr>';

    $('#'+elementId).html(row);
}

function displayContentMsg(element, msg) {
    let elem = '<div class="text-center w-100 d-block text-muted my-5 py-5 shake_in fs-5">'+msg+'</div>';

    $(element).html(elem);
}

window.addEventListener('load', function () {
    setTimeout(() => {
        hideLoadingScreen()
    }, 1000);
})


function popInOnScroll() {
    // pop_in_on_scroll
    // pop_in_on_scroll_to_left
    // pop_in_on_scroll_to_right

    let elements = document.querySelectorAll('.pop_in_on_scroll')
    let elementsToLeft = document.querySelectorAll('.pop_in_on_scroll_to_left')
    let elementsToRight = document.querySelectorAll('.pop_in_on_scroll_to_right')

    elements.forEach(element => {

        let windowHeight = window.innerHeight
        let reavelTop = element.getBoundingClientRect().top

        let onScrollSubstraction = 0

        

        if (element.classList.contains("advanceScroll")) {
            onScrollSubstraction = -150
        } 

        if (reavelTop < windowHeight - onScrollSubstraction) {

            let delayScroll = 1

            if (element.classList.contains("delayScroll")) {
                delayScroll = element.dataset.delayscroll;

                if (delayScroll == undefined || delayScroll == "" || delayScroll == null) {
                    delayScroll = 150;
                } else {
                    delayScroll = delayScroll;
                }
            }
            
            if (!element.classList.contains('scroll_revealed')) {
                setTimeout(() => {
                    element.classList.add('scroll_revealed')

                    setTimeout(() => {
                        element.classList.remove('pop_in_on_scroll')
                        element.classList.remove('scroll_revealed')
                    }, 1000);
                }, delayScroll);
                
            }
        }
    });

    elementsToLeft.forEach(element => {

        let windowHeight = window.innerHeight
        let reavelTop = element.getBoundingClientRect().top

        let onScrollSubstraction = 0

        

        if (element.classList.contains("advanceScroll")) {
            onScrollSubstraction = -150
        } 

        if (reavelTop < windowHeight - onScrollSubstraction) {

            let delayScroll = 1

            if (element.classList.contains("delayScroll")) {
                delayScroll = element.dataset.delayscroll;

                if (delayScroll == undefined || delayScroll == "" || delayScroll == null) {
                    delayScroll = 150;
                } else {
                    delayScroll = delayScroll;
                }
            }
            
            if (!element.classList.contains('scroll_revealed_to_left')) {
                setTimeout(() => {
                    element.classList.add('scroll_revealed_to_left')

                    setTimeout(() => {
                        element.classList.remove('pop_in_on_scroll_to_left')
                        element.classList.remove('scroll_revealed_to_left')
                    }, 1000);
                }, delayScroll);
                
            }
        }
    });

    elementsToRight.forEach(element => {

        let windowHeight = window.innerHeight
        let reavelTop = element.getBoundingClientRect().top

        let onScrollSubstraction = 0

        

        if (element.classList.contains("advanceScroll")) {
            onScrollSubstraction = -150
        } 

        if (reavelTop < windowHeight - onScrollSubstraction) {

            let delayScroll = 1

            if (element.classList.contains("delayScroll")) {
                delayScroll = element.dataset.delayscroll;

                if (delayScroll == undefined || delayScroll == "" || delayScroll == null) {
                    delayScroll = 150;
                } else {
                    delayScroll = delayScroll;
                }
            }
            
            if (!element.classList.contains('scroll_revealed_to_right')) {
                setTimeout(() => {
                    element.classList.add('scroll_revealed_to_right')

                    setTimeout(() => {
                        element.classList.remove('pop_in_on_scroll_to_right')
                        element.classList.remove('scroll_revealed_to_right')
                    }, 1000);
                }, delayScroll);
                
            }
        }
    });
    
}

popInOnScroll()

document.addEventListener('scroll', function (param) { popInOnScroll() })