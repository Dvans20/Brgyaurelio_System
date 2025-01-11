let cropper = null
let encryptedCroppedImage = null
// const cropperModal = document.getElementById("cropperModal")

const cropperDestroyed =  new Event('cropper_destroyed')
const cropperCreated = new Event('cropper_created')

function setImageCropper(imagePreviewID, modalId, e) {

    if (cropper != null) {
        destroyCropper()
    }


    let image = document.getElementById(imagePreviewID)

    let acceptableExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG']

    var file = e.target.files

    var fileName = file[0].name
    var fileNameExt = fileName.substring(fileName.lastIndexOf('.')+1, fileName.length)


    if (!isExist(acceptableExtensions, fileNameExt)) {

        var err = {
            'status': 'File not supported!',
            'statusText': 'Only images with jpg, jpeg, or png extensions are acceptable.'
        }
        displayError(err)
    } else {
        var done = function(url) {
            image.src = url
            let modal = new bootstrap.Modal(document.getElementById(modalId))

            modal.show()
        }

        if (file && file.length > 0) {
            reader = new FileReader()
            reader.onload = function (e) {
                done(reader.result)
            }
            reader.readAsDataURL(file[0])
        }
    }
}

function openCropperModal(modalId) {
    let modal = document.getElementById(modalId)
    modalBS = new bootstrap.Modal(modal);

    modalBS.show();
}

function setImageCropperBySnap(data) {
    image.src = data
    openModal("cropperModal")
}

// cropperModal.addEventListener('modal_opened', function () {
//     createCropper('.preview')
// })

// cropperModal.addEventListener('modal_closed', function () {
//     setCroppedImaged()
// })

function createCropper(preview, image) {

    if (cropper != null) {
        destroyCropper()
    }

    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 2,
        preview: preview
    });

    window.dispatchEvent(cropperCreated)
}

function destroyCropper() {
    if (cropper != null) {
        cropper.destroy()
        cropper = null
        window.dispatchEvent(cropperDestroyed)
    }

    encryptedCroppedImage = null
}

function setCroppedImaged() {
    if (cropper != null) {
        try {
            canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500
            })

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob)
                var reader = new FileReader()
                reader.readAsDataURL(blob)
                reader.onload = function () {
                    encryptedCroppedImage = reader.result
                }
            })
        } catch (error) {
            // console.log(error)
            var err = {
                'status': "Something went wrong!",
                'statusText': "Please contact the developer if this message occurs."
            }
            displayError(err)
        }
    }

}

alert('ss');