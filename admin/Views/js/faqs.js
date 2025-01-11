

let faqsFormModal = document.getElementById('faqsFormModal')
let faqsFormModalBS = new bootstrap.Modal(faqsFormModal)





faqsFormModal.addEventListener('hidden.bs.modal', function () {
    
})

$('#addNewFaqBtn').click(function (e) { 
    e.preventDefault();
    $('#faqsFormModalheading').html(" New FAQ");
    faqsFormModalBS.show()
});

$('#faqsFormModal').submit(function (e) { 
    e.preventDefault();

    
    
});