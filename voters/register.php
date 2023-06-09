<?php
session_start();
include('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];

    // Insert the voter's information into the database
    $sql = "INSERT INTO voters (name, age, address) VALUES ('$name', '$age', '$address')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = 'Registration successful!';
        setcookie('voter_name', $name, time() + (86400 * 30), '/'); // Set a cookie with the voter's name
    } else {
        $_SESSION['error'] = 'Registration failed. Please try again.';
    }
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voter Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Voter Registration</h2>

        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form id="registrationForm" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Submit the registration form via Ajax
            $('#registrationForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'register.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#registrationForm')[0].reset(); // Reset the form
                        $('#registrationForm .form-control').removeClass('is-invalid'); // Reset input validation
                        if (response.includes('Registration successful!')) {
                            window.location.href = 'dashboard.php'; // Redirect to the dashboard page
                        } else {
                            $('#registrationForm .form-control').addClass('is-invalid'); // Show input validation errors
                            alert(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
