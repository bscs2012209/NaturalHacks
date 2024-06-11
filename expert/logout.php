<?php
session_start();
if (isset($_SESSION['expert_id']) || $_SESSION['is_expert'] === 'expert') {
    session_destroy();
}
header("Location: ./login.php");
exit();
?>
