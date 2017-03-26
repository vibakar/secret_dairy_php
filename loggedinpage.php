<?php
ob_start();
session_start();
include 'header.php';
include 'db.php';
if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];
}
?>

<div class="container-fluid">
    <nav class="navbar navbar-light bg-faded">
        <a class="navbar-brand" href="#">Secret Dairy</a>

        <form class="float-xs-right">

            <button class="btn btn-outline-success" type="submit"><?php
                if (isset($_SESSION['id'])) {
                    $id = mysqli_real_escape_string($con, $_SESSION['id']);
                    echo '<a href="index.php?logout=1">logout</a>';
                    $sql = "SELECT mydairy FROM dairy WHERE id=$id";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        $row = mysqli_fetch_array($result);
                        $dairy = $row['mydairy'];
                    }
                } else {
                    header("Location: index.php");
                }
                ?></button>
        </form>
    </nav>
    <textarea id="dairy" class="form-control" rows="50">
        <?php
            if(isset($dairy)){
                echo $dairy;
            }
          
         ?>
        </textarea>
    </div>
    <?php include 'footer.php'; ?>