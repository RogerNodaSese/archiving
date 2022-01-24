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
            Swal.fire(
                'Verified!',
                'Request has been verified.',
                'success'
            )
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
