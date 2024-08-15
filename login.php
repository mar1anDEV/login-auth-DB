<?php 

$hostname = 'localhost';
$username = 'testroot';
$password = 'Nikos445';
$database = 'registration';

// Establish a connection to the database
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the statement
    if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?')) {
        // Bind parameters
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        
        // Store the result
        $stmt->store_result();

        // Check if username exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashedPassword);
            $stmt->fetch();

            // Verify the password
            if (password_verify($_POST['password'], $hashedPassword)) {
                // Successful login
                echo 'Welcome';
                // Here you would typically start a session and set session variables
                 session_start();
                 $_SESSION['user_id'] = $id;
                 $_SESSION['username'] = $_POST['username'];
                 header('Location: https://marian2702.github.io/portfolio/'); // Redirect to a secure page
            } else {
                // Incorrect password
                echo 'Incorrect username and/or password!';
            }
        } else {
            // Incorrect username
            echo 'Incorrect username and/or password!';
        }
        $stmt->close();
    } else {
        echo 'Database query failed!';
    }
}

$conn->close();
?>
