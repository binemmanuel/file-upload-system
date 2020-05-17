let modal = document.querySelector('#add-new-modal')
let add_btn = document.querySelector('#add-btn')

if (add_btn.attributes !== null) {
    // Remove href attribute.
    add_btn.attributes.removeNamedItem('href')
}

// Hide modal.
modal.style.display = 'none'

add_btn.addEventListener('click', function () {
    if (modal.style.display !== 'block') {
        modal.style.display = 'block'
    } else {
        modal.style.display = 'none'
    }
})

/* Validate names. */
function validate_name(input, error_block) {
    // Check if names are less than 3
    if (input.value.length < 5) {
        // Display an error message to the user.
        error_block.innerText = 'Please enter a valid name'
        error_block.style.display = 'block'
        error_block.classList.add('alert-danger')

    } else {
        error_block.innerText = ''
        error_block.style.display = 'none'
    } 
}

/* Validate week. */
function validate_week(input, error_block) {
    // Check if the week is valid.
    if (input.value < 1 || input.value > 4) {
        // Display an error message to the user.
        error_block.innerText = 'Please enter a valid week number (1 - 4)'
        error_block.style.display = 'block'
        error_block.classList.add('alert-danger')
    } else {
        // Hide error block.
        error_block.innerText = ''
        error_block.style.display = 'none'
    }
}

/* Validate date.length. */
function validate_date(input, error_block) {
    let date = input.value.split('-')
    
    if (isNaN(date[0]) && isNaN(date[1]) && isNaN(date[2])) {
        // Display an error message to the user.
        error_block.innerText = 'Invalid date'
        error_block.style.display = 'block'
        error_block.classList.add('alert-danger')

    } else if ((date.length[0] < 4 || date.length[0] > 4) && (date.length[1] < 2 || date.length[1] > 2) && (date.length[2] < 2 || date.length[2] > 2)) {
        // Display an error message to the user.
        error_block.innerText = 'Invalid date'
        error_block.style.display = 'block'
    }
}

$('document').ready(function () {
    // Hide modal after 10000ms.
    $('#success_block').fadeOut(9000);
    $('#error_block').fadeOut(9000);
    
    // Hide #eye-slash be deault.
    $('#eye_slash').hide();
});

function get_user_id(user, field) {
    field.value = user
}

function show_pass(password, eye_open, eye_slash) {

    // Check password type.
    if (password.type === 'password') {
        // Check password type to text.
        password.type = 'text';

        // Hide #eye_open icon.
        eye_open.style.display = 'none';
        
        // Show #eye_slash icon.
        eye_slash.style.display = 'block';
    } else {
        // Check password type to text.
        password.type = 'password';

        // Show #eye_open icon.
        eye_open.style.display = 'block';
        
        // Hide #eye_slash icon.
        eye_slash.style.display = 'none';
    }  
}

function validate_email(email, error_block) {
    let result = /[\w]+@[\Az]+\.[\Az]{3}/.test(email.value)
    
    if (result === false) {
        // Display an error message.
        error_block.innerText = 'Invalid email address.'
        error_block.style.display = 'block'
    } else {
        // Hide error message.
        error_block.style.display = 'none'
    }
}

function get_emp_rec() {
    let emp = $('#emp').val();
    
    $('#load-record').load("load-reports.php", 
        {
            name: emp,
            action: 'get-emp-reports'
        }
    );

}

