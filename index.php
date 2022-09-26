<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/register.css">
    <title>Register</title>
</head>
<body>
<?php
    require_once '../databases/ssesion.php';
    require_once  '../databases/config.php';

$data = "SELECT * FROM users.users";
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    $query = $db->prepare("SELECT * FROM users.users WHERE email= ?");
    $query->bind_param(":email", $email);
    $query->execute();

    $query = $db->prepare("INSERT INTO users.users(name,password,email) VALUES (:username,:password_hash,:email)");
    $query->bind_param(":username", $username);
    $query->bind_param(":password_hash", $password_hash);
    $query->bind_param(":email", $email);
    $result = $query->execute();

    if ($result) {
        echo '<p class="success">Регистрация прошла успешно!</p>';
    } else {
        echo '<p class="error">Неверные данные!</p>';
    }

}

/*
if($users = mysqli_query($db, $data)){
    if(mysqli_num_rows($users) > 0){
        while($user = mysqli_fetch_array($users)) {
            echo "<div>
                   <div>" . $user['id'] . "</div>
                   <div>" . $user['name'] . "</div>
                   <div>" . $user['email'] . "</div>
                   <div>" . $user['password'] . "</div>
                 </div>";
        }
        mysqli_free_result($users);
    } else {
        echo "<p class='lead'><em>No records found.</em></p>";
    }
} else {
    echo "ERROR: Could not able to execute. " . mysqli_error($db);
}

mysqli_close($db);
*/
?>

<form action="./register.php" method="post" class="form">
            <div>
                <h1>Sign Up</h1>
            </div>
            <div class="form-box">
                <div class="input">
                    <label for="username">Name account</label>
                    <input type="text" pattern="[a-zA-Z0-9]+" name="username" class="username" placeholder="nickname account" required>
                    <div class="error-username" aria-live="polite"></div>
                </div>
                <div class="input">
                    <label for="password">Password account</label>
                    <input type="password" name="password" class="password" placeholder="password" required>
                    <div class="error-password" aria-live="polite"></div>
                </div>
                <div class="input">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="email" placeholder="email@email.com" required>
                    <div class="error-email" aria-live="polite"></div>
                </div>
                <div class="input">
                    <button type="submit" name="register" class="register">Register</button>
                </div>
                <div>У вас уже есть учетная запись? <a href="./login.php">Войдите в систему здесь.</a></div>
            </div>
        </form>
        
       <!-- code -->
</body>
</html>
