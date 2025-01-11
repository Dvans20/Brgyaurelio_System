
const userFormModal = document.getElementById('userFormModal');
const userFormModalBS = new bootstrap.Modal(userFormModal);
const userForm = document.getElementById('userForm');

const editAccessTypeFormModal = document.getElementById('editAccessTypeFormModal');
const editAccessTypeFormModalBS = new bootstrap.Modal(editAccessTypeFormModal);
const editAccessTypeForm = document.getElementById('editAccessTypeForm');


const deleteUserModal = document.getElementById('deleteUserModal')
const deleteUserModalBS = new bootstrap.Modal(deleteUserModal)


let currentPage;

const ACCESSTYPES = ["Administrator", "Secretary", "Treasurer"];




// user row
let userRow = function (index, user) {

    

    let editAccessTypeBtn = '<button class="btn btn-sm ms-1 btn-info" type="button" onclick="editAccessType('+user.id+','+user.accessType+')">'+
       ' <span class="fas fa-edit"></span>' +
    '</button>';

    let deleteUserBtn = '<button class="btn btn-sm ms-1 btn-danger" type="button" onclick="deleteUser('+user.id+',\''+user.name+'\')">'+
       ' <span class="fas fa-trash-alt"></span>' +
    '</button>';

    let noCol = '<td class="text-center">'+(index+1)+'</td>';
    let nameCol = '<td class="text-start">'+(user.name)+'</td>';
    let emailCol = '<td class="text-start">'+(user.email)+'</td>';
    let userTypeCol = '<td class="text-center" id="userTypeCol'+user.id+'">'+(ACCESSTYPES[user.accessType - 1])+'</td>';

    let actCol = '<td><div class="d-flex justify-content-end">'+(editAccessTypeBtn)+(deleteUserBtn)+'</div></td>';

    let row = '<tr class="slide_in" id="row'+user.id+'">'+noCol+nameCol+emailCol+userTypeCol+actCol+'</tr>';

    return row;
}


userFormModal.addEventListener('hidden.bs.modal', function () {
    userForm.reset();
})

deleteUserModal.addEventListener('hidden.bs.modal', function () {
    $('#userIdToDelete').val("");
    $('#loggedInUserPasswordForDelete').val("");
})

$('#userForm').submit(function (e) { 
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=userForm",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    userFormModalBS.hide();
                    getUsers($('#search').val(), 1)
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
                displayMsg(1, err.status + " : " + err.responseText);
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
    
});

$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getUsers($('#search').val(), 1)
});

function getUsers(search, page) {
    let data = {
        'search' : search,
        'page': page,
        'limit' : LIMIT
    }
    

    $.ajax({
        type: "GET",
        url: "submits/usersRequests.php?action=getUsers",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent("#usersList", 5)
        },
        success: function (response) {
            setTimeout(() => {

                users = response.users;

                $('#usersList').html("")
                $('#userLinks').html("")
                if (users == null) {
                    displayTableMsg("usersList", 5, "Something went wrong.");
                } else {
                    $.each(users, function (index, user) { 
                        $('#usersList').append(userRow(index, user));
                    });
                    currentPage = page
                    displayPagination("userLinks", page, "paginateUsers", response.totalPages);
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
                displayTableMsg("usersList", 5, "Something went wrong.");
            }, timeout + 300);
        },
        complete: function () {
            // setTimeout(() => {
                // hideLoadingTableContent("usersList")
            // }, timeout);
        }
    });
}

function paginateUsers(page) {
    getUsers($('#search').val(), page)
}


$('#userFormTogglePasswordBtn').click(function (e) { 
    e.preventDefault();
    if ($('#password').attr('type') == "password") {
        $('#password').prop('type', 'text')
        $('#confirmPassword').prop('type', 'text')
        $(this).html('<span class="fas fa-eye-slash"></span> Hide Password')
    } else {
        $('#password').prop('type', 'password')
        $('#confirmPassword').prop('type', 'password')
        $(this).html('<span class="fas fa-eye"></span> See Password')
    }
});


function editAccessType(id, accessType) {
    
    $.ajax({
        type: "GET",
        url: "submits/usersRequests.php?action=getUser",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (user) {
            setTimeout(() => {
                editAccessTypeFormModalBS.show()
                $('#userIdToEditAccessType').val(user.id);
                $('#newAccessType').val(user.accessType);
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
               console.log(err) 
               displayMsg(1, "Something went wrong!")
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
               hideLoadingScreen(); 
            }, timeout);
        }
    });
}

$('#editAccessTypeForm').submit(function (e) { 
    e.preventDefault();
    
    let data = {
        'id' :   $('#userIdToEditAccessType').val(),
        'accessType' : $('#newAccessType').val()
    }

    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=updateAccessType",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    editAccessTypeFormModalBS.hide();
                    $('#userTypeCol' + data.id).html(ACCESSTYPES[data.accessType - 1])
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, "Something went wrong!");
                editAccessTypeFormModalBS.hide();
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
    
});

function deleteUser(id, name) {
    deleteUserModalBS.show()

    $('#userIdToDelete').val(id);
    $('#userNameToDelete').html(name + "'s");
}

$('#deleteUserBtn').click(function (e) { 
    e.preventDefault();

    let data = {
        'id': $('#userIdToDelete').val(),
        'password': $('#loggedInUserPasswordForDelete').val()
    }
    
    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=deleteUser",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    deleteUserModalBS.hide();
                    getUsers($('#search').val(), 1)
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err.responseText)
                displayMsg(1, "Something went wrong.");
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
});

setTimeout(() => {
    getUsers("", 1)
}, timeout);