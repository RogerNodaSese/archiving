function del(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form' + id).submit()
        }
    })
}

function rem(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This request will be rejected!",
        icon: 'question',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form' + id).submit()
        }
    })
}

function verify(id) {
    Swal.fire({
        title: 'This request will be verified',
        text: "You won't be able to revert this!",
        icon: 'info',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Verify!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('submit-form' + id).submit()
        }
    })
}

function deleted() {
    Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
    )
}

function remove(){
    Swal.fire(
        'Rejected!',
        'Request has been rejected.',
        'success'
    )
}

function submitted(){
    Swal.fire(
        'Submitted',
        'Your request has been submitted.',
        'success'
    )
}

function resubmit(id){
    Swal.fire({
        title: 'Are you sure you want to Submit?',
        icon: 'question',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#38c172',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('submit-form' + id).submit()
        }
    })
}

function verified(){
    Swal.fire(
        'Verified',
        'Requests has been verified',
        'success'
    )
}
