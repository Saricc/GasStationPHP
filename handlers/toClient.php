<?php

function toClient($msg)
{
    header("Content-Type: application/json");
    echo json_encode($msg);
}
