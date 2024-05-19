<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .invalid { border-color: #dc3545 !important; }
        .error-message { color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }
        .weak-password { border-color: #dc3545 !important; }
        .moderate-password { border-color: #ffc107 !important; }
        .strong-password { border-color: #28a745 !important; }
    </style>
</head>
<body>
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                <form class="mx-1 mx-md-4" action="process.php" method="POST" autocomplete="off">
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="student_id">Student ID</label>
                                            <input type="text" id="student_id" class="form-control" name="student_id" required/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="firstname">First Name</label>
                                            <input type="text" id="firstname" class="form-control" name="firstname" required/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="middlename">Middle Name <small>(Optional)</small></label>
                                            <input type="text" id="middlename" class="form-control" name="middlename" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="lastname">Last Name</label>
                                            <input type="text" id="lastname" class="form-control" name="lastname" required/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" id="email" class="form-control" name="email" required/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" class="form-control" name="password" required/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="repassword">Repeat password</label>
                                            <input type="password" id="repassword" class="form-control" name="repassword" required/>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg" name="registerButton">Register</button>
                                    </div>
                                    <div class="text-center text-lg-start mt-4 pt-2">
                                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="login.php" class="link-danger">Login</a></p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const requiredInputs = document.querySelectorAll('input[required]');
    const studentIdInput = document.querySelector('input[name="student_id"]');
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const repasswordInput = document.querySelector('input[name="repassword"]');
    const firstNameInput = document.querySelector('input[name="firstname"]');
    const lastNameInput = document.querySelector('input[name="lastname"]');

    document.querySelector('form').addEventListener('submit', (event) => {
        validateInput(studentIdInput);
        validateInput(emailInput);
        validateInput(firstNameInput);
        validateInput(lastNameInput);
        
        const passwordStrength = getPasswordStrength(passwordInput.value);
        if (passwordStrength === 'weak') {
            passwordInput.classList.add('invalid');
            event.preventDefault();
            let errorMessage = passwordInput.parentNode.querySelector('.error-message');
            if (!errorMessage) {
                errorMessage = document.createElement('div');
                errorMessage.classList.add('error-message');
                passwordInput.parentNode.appendChild(errorMessage);
            }
            errorMessage.textContent = 'Password must be at least 8 characters long and contain at least one digit and one lowercase letter';
        } else {
            passwordInput.classList.remove('invalid');
            const errorMessage = passwordInput.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }

        if (passwordInput.value !== repasswordInput.value) {
            passwordInput.classList.add('invalid');
            repasswordInput.classList.add('invalid');
            event.preventDefault();
            let errorMessage = repasswordInput.parentNode.querySelector('.error-message');
            if (!errorMessage) {
                errorMessage = document.createElement('div');
                errorMessage.classList.add('error-message');
                repasswordInput.parentNode.appendChild(errorMessage);
            }
            errorMessage.textContent = 'Passwords do not match';
        } else {
            passwordInput.classList.remove('invalid');
            repasswordInput.classList.remove('invalid');
            const errorMessage = repasswordInput.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }
    });

    function validateInput(input) {
        if (input.value.trim() === '') {
            input.classList.add('invalid');
            const errorMessage = document.createElement('div');
            errorMessage.textContent = `${input.previousElementSibling.textContent} is required`;
            errorMessage.classList.add('error-message');
            input.parentNode.appendChild(errorMessage);
        } else {
            input.classList.remove('invalid');
            const errorMessage = input.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }
    }

    function getPasswordStrength(password) {
        const weakRegex = /^.{1,7}$/;
        const moderateRegex = /^(?=.*\d)(?=.*[a-z]).{8,}$/;
        const strongRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

        if (strongRegex.test(password)) {
            return 'strong';
        } else if (moderateRegex.test(password)) {
            return 'moderate';
        } else if (weakRegex.test(password)) {
            return 'weak';
        } else {
            return 'weak';
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzF9F1hbjfb3zJpP4hPb5Ntvr1Rtzv6d6M56P4wWE1uX" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-GJzZqFGwbIQiyxy7ipF+pmTW3QEH42XtLJJkDByG/jyNG4kz+6tBt+5TIQ7cx0p3" crossorigin="anonymous"></script>
</body>
</html>
