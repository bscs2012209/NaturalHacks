<?php

function getRemedyDetail($id, $connection)
{
    $remedy_name_sql = "SELECT * FROM remedies WHERE id = '$id' AND expert_approval = 'approved'";
    $remedy_name_detail = mysqli_query($connection, $remedy_name_sql);

    return mysqli_fetch_assoc($remedy_name_detail);
}


?>