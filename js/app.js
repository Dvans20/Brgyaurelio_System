



let appLoaderModal = document.getElementById('appLoaderModal')
let appLoaderModalBS = new bootstrap.Modal(appLoaderModal)



showLoadingScreen = function() {
    appLoaderModalBS.show()
}

hideLoadingScreen = function () {
    setTimeout(() => {
        appLoaderModalBS.hide()
    }, 500);
}