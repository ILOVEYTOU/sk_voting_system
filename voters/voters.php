<!DOCTYPE html>
<html>
<head>
    <title>Voters</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin-top: 100px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .card-text {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            transition: background-color 0.3s ease-in-out;
            font-weight: 600;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background-color: #534dff;
            border-color: #534dff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Voters Portal</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title">Login</h4>
                        <p class="card-text">Already have an account? Click below to log in.</p>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title">Register</h4>
                        <p class="card-text">New to the system? Register your account by clicking below.</p>
                        <a href="register.php" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
