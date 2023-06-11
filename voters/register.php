<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sk_voting_system";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .form-group input {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ccc;
            width: 100%;
            transition: border-color 0.3s ease-in-out;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6c63ff;
        }

        .invalid-feedback {
            color: #dc3545;
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            transition: background-color 0.3s ease-in-out;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 8px;
            padding: 12px 30px;
        }

        .btn-primary:hover {
            background-color: #534dff;
            border-color: #534dff;
        }

        h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #6c63ff;
        }

        .alert {
            border-radius: 8px;
        }

        .alert-success {
            background-color: #d1e7dd;
            border-color: #badbcc;
            color: #0f5132;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 15px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 15px;
        }

        .voting-system-icon {
            font-size: 64px;
            color: #6c63ff;
            margin-bottom: 20px;
        }

        /* Custom Styles */
        .sk-color {
            --primary-color: #FF4081; /* Pink */
            --primary-dark-color: #E91E63; /* Dark Pink */
            --text-color: #FFFFFF; /* White */
            --success-color: #d1e7dd;
            --success-border-color: #badbcc;
            --success-text-color: #0f5132;
            --error-color: #f8d7da;
            --error-border-color: #f5c6cb;
            --error-text-color: #721c24;
        }

        .sk-color .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .sk-color .btn-primary:hover {
            background-color: var(--primary-dark-color);
            border-color: var(--primary-dark-color);
        }

        .sk-color h2 {
            color: var(--primary-color);
        }

        .sk-color .voting-system-icon {
            color: var(--primary-color);
        }

        .sk-color .alert-success {
            background-color: var(--success-color);
            border-color: var(--success-border-color);
            color: var(--success-text-color);
        }

        .sk-color .alert-danger {
            background-color: var(--error-color);
            border-color: var(--error-border-color);
            color: var(--error-text-color);
        }

    </style>
</head>
<body>
    <div class="container sk-color">
        <div class="text-center">
            <i class="fas fa-vote-yea voting-system-icon"></i>
            <h2>Voter Registration</h2>
        </div>

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
                        <div class="form-group">
                            <label for="voter_id">Voter ID</label>
                            <input type="text" class="form-control" id="voter_id" name="voter_id" required pattern="[0-9]{7,}">
                            <div class="invalid-feedback">
                                Please provide a valid voter ID (minimum 7 digits).
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">
                                Please provide your full name.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" name="age" required min="18">
                            <div class="invalid-feedback">
                                Please provide your age (must be 18 or above).
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                            <div class="invalid-feedback">
                                Please provide your address.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="precinct_number">Precinct Number</label>
                            <input type="text" class="form-control" id="precinct_number" name="precinct_number" required>
                            <div class="invalid-feedback">
                                Please provide the precinct number.
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-success" role="alert">
                Thank you for registering, <?php echo $_SESSION['voter_name']; ?>!
            </div>

            <div class="text-center">
                <a href="register.php" class="btn btn-primary">Register New User</a>
            </div>
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
