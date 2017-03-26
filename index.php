<?php
ob_start();
session_start();
include 'db.php';

if (isset($_POST['signup'])) {
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    $sql = "SELECT id FROM dairy WHERE email='$email' ";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $error = "Email Already Exists";
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO dairy(email,password) VALUES('$email','$password')";
        $result = mysqli_query($con, $sql);
        if ($_POST['stayloggedin'] == "1") {
            setcookie("id", mysqli_insert_id($con), time() + 60 * 60 * 24 * 365);
        }
        if ($result) {
            $_SESSION['id'] = mysqli_insert_id($con);
            header("Location: loggedinpage.php");
        }
    }
} elseif (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    $sql = "SELECT * FROM dairy WHERE email='$email'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];
        if (isset($_POST['stayloggedin']) == "1") {
            setcookie("id", $row['id'], time() + 60 * 60 * 24 * 365);
        }
        if (mysqli_num_rows($result) > 0 && password_verify($password, $db_password)) {
            $_SESSION['id'] = $row['id'];
            header("Location: loggedinpage.php");
        } else {
            $error = "Email or Password Incorrect";
        }
    }
}
?>
<?php
if (isset($_GET['logout']) && $_GET['logout'] == 1) {

    $_SESSION['id'] = null;
    setcookie("id", "", time() - 60 * 60);
    header("Location: index.php");
} elseif (isset($_SESSION['id']) || isset($_COOKIE['id'])) {
    header("Location: loggedinpage.php");
}
?>



<?php include 'header.php'; ?>
<div class="container" id="index">
    <h1>Secret Dairy</h1>
    <p>Store your secret thoughts</p>
    <p>Interested? Sign up</p>
    <div id="error">

        <?php
        if (isset($error)) {
            echo '<div class = "alert alert-success" role = "alert">' . $error . '</div>';
        }
        ?>

    </div>
    <form method="post" id="signupform">
        <fieldset class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Your Email" required />
        </fieldset>
        <fieldset class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password" required/>
        </fieldset>
        <div class="form-group">
            <input type="checkbox" name="stayloggedin" value="1"/>stay logged in
        </div>
        <input class="btn btn-info" type="submit" name="signup" value="Sign up" />
        <p class="link"><a  class="toggle">Log in</a></p>
    </form>

    <form method="post" id="loginform">

        <fieldset class="form-group" >
            <input type="email" class="form-control" name="email" placeholder="Your Email" required />
        </fieldset>
        <fieldset class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required />
        </fieldset>
        <div class="form-group">
            <input type="checkbox" name="stayloggedin" value="1"/>stay logged in
        </div>
        <input class="btn btn-primary" type="submit" name="login" value="Login" />
        <p class="link"><a  class="toggle">Sign up</a></p>
    </form>


</div>
<?php include 'footer.php'; ?>






