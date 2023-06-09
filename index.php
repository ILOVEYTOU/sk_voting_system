<!DOCTYPE html>
<html>
<head>
    <title>SK Voting System</title>
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #dc3545;
        }
        .list-group-item {
            background-color: #fff;
            border-color: #dee2e6;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
        }
        .list-group-item a {
            display: block;
            padding: 15px;
            color: #495057;
            text-decoration: none;
        }
        .user-type-content {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background-color: #fff;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to SK Voting System</h1>
        <h3>Select Portal</h3>

        <div class="list-group">
            <a href="voters/voters.php" class="list-group-item" onclick="loadUserType('voters.php')">Voter</a>
            <a href="#" class="list-group-item" onclick="loadUserType('guest.php')">Guest</a>
            <a href="#" class="list-group-item" onclick="loadUserType('watcher.php')">Watcher</a>
            <a href="#" class="list-group-item" onclick="loadUserType('candidates.php')">Candidates</a>
            <a href="#" class="list-group-item" onclick="loadUserType('candidacy.php')">Candidacy</a>
        </div>

        <div id="userTypeContent" class="user-type-content"></div>
    </div>

    <script>
        function loadUserType(url) {
            $('.user-type-content').slideUp('fast', function() {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#userTypeContent').html(response);
                        $('.user-type-content').slideDown('fast');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        }
    </script>
</body>
</html>
