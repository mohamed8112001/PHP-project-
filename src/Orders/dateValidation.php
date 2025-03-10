<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$location = ($_GET['path'] == 2) ? "checks.php" : "userOrders.php";
if( isset($_GET['dateFrom']) && isset($_GET['dateTo']) )
{
    $dateFrom =$_GET['dateFrom'];
    $dateTo=$_GET['dateTo'];
    
    if( strtotime($dateFrom) > strtotime($dateTo) )
    {
        $_SESSION['error']= "The entered date range is not valid.";
        header("Location: $location ");
    }else{
        $user=$_GET['user'];
        header("Location: $location?dateFrom=$dateFrom&dateTo=$dateTo&user=$user");
    }
}else{
    $_SESSION['error']= "Both dates must be selected.";
    header("Location: $location ");
}
?>