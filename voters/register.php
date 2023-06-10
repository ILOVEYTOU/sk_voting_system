<?php
session_start();
include('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voter_id = $_POST['voter_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $precinct_number = $_POST['precinct_number'];

    // Validate age
    if ($age < 18) {
        $_SESSION['error'] = 'You must be 18 years or older to register as a voter.';
        header('Location: register.php');
        exit();
    }

    // Insert the voter's information into the database
    $sql = "INSERT INTO voters (voter_id, name, age, address, precinct_number) VALUES ('$voter_id', '$name', '$age', '$address', '$precinct_number')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = 'Registration successful!';
        $_SESSION['voter_name'] = $name; // Create a new session variable for the voter's name
        header('Location: register.php');
        exit();
    } else {
        $_SESSION['error'] = 'Registration failed. Please try again.';
        header('Location: register.php');
        exit();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voter Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            transition: background-color 0.3s ease-in-out;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #534dff;
            border-color: #534dff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Voter Registration</h2>

        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']); ?>
            </div>
            <?php unset($_SESSION['voter_name']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!isset($_SESSION['voter_name'])) : ?>
            <div class="card">
                <div class="card-body">
                    <form id="registrationForm" method="post">
                        <div class="mb-3">
                            <label for="voter_id" class="form-label">Voter ID</label>
                            <input type="text" class="form-control" id="voter_id" name="voter_id" required pattern="[0-9]{7,}">
                            <div class="invalid-feedback">
                                Please provide a valid voter ID (minimum 7 digits).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">
                                Please provide your name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" required min="18">
                            <div class="invalid-feedback">
                                Please provide your age (must be 18 or above).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                            <div class="invalid-feedback">
                                Please provide your address.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precinct_number" class="form-label">Precinct Number</label>
                            <input type="text" class="form-control" id="precinct_number" name="precinct_number" required>
                            <div class="invalid-feedback">
                                Please provide the precinct number.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-success" role="alert">
                Thank you for registering, <?php echo $_SESSION['voter_name']; ?>!
            </div>

            <a href="register.php" class="btn btn-primary">Register New User</a>
        <?php endif; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                $(this).addClass('was-validated');
            });

            $('#registrationForm .form-control').on('change', function() {
                $(this).removeClass('is-invalid');
                $('#registrationForm').removeClass('was-validated');
            });
        });
    </script>
</body>
</html>
