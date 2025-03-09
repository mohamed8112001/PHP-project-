<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if( isset($_GET['dateFrom']) && isset($_GET['dateTo']) )
{
    $dateFrom =$_GET['dateFrom'];
    $dateTo=$_GET['dateTo'];
    
    if( strtotime($dateFrom) > strtotime($dateTo) )
    {
        $_SESSION['error']= "The entered date range is not valid.";
        header("Location: userOrders.php");
    }else{
        header("Location: userOrders.php?dateFrom=$dateFrom&dateTo=$dateTo");
    }
}else{
    $_SESSION['error']= "Both dates must be selected.";
    header("Location: userOrders.php");
}
?>