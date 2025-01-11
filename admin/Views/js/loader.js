

var showLoadingScreen = function () {
    if (!document.querySelector('.loading_screen_loader')) {
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

function hideLoadingScreen() {
    let loadingScreenLoader = document.getElementById("loadingScreenLoader")

    setTimeout(() => {
        $('.loading_screen_loader').addClass('fade_out')
        setTimeout(() => {
            $('.loading_screen_loader').remove()
        }, 200);
    }, 200);

}


function showLoadingTableContent(element, colspan) {

    let loader = '<div class="loading_content_loader"><div class="loader09-2"></div></div>'


    let col = '<td colspan="'+colspan+'">'+loader+'</td>';

    let row = '<tr>'+col+'</tr>';

    $(element).html(row);
}

function showLoadingContent(element) {

    let loader = '<div class="loading_content_loader"><div class="loader09-2"></div></div>'



    $(element).html(loader);
}

function hideLoadingContent(element) {
    $(element + " .loading_content_loader").addClass('fade_out')
    setTimeout(() => {
        $(element + " .loading_content_loader").remove()
    }, 0);
}

function hideLoadingTableContent(element) {
    $(element).addClass('fade_out')
    setTimeout(() => {
        $(element).remove()
    }, 0);
}


showLoadingScreen();