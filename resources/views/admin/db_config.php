<?php
$hostname = 'localhost';
$username = 'root';
$pass = '';
$db = 'quanlykhachsan';

$con = mysqli_connect($hostname, $username, $pass, $db);

if (!$con) {
    die("Không thể kết nối đến Database" . mysqli_connect_error());
}
function filteration($data)
{
    foreach ($data as $key => $value) {
        $data[$key] = trim($value);
        $data[$key] = stripcslashes($value);
        $data[$key] = htmlspecialchars($value);
        $data[$key] = strip_tags($value);
    }
    return $data;
}

function select($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Querry cannot be executed - Select");
        }
    } else {
        die("Querry cannot be prepared - Select");
    }
}
function selectAll($table)
{
    $con = $GLOBALS['con'];
    $res = mysqli_query($con, "SELECT * FROM $table");
    return $res;
}
function insert($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("QUERY CANNOT BE EXECUTED - INSERT");
        }
    } else {
        die("QUERY CANNOT BE EXECUTED - INSERT");
    }
}
function update($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("QUERY CANNOT BE EXECUTED - UPDATE");
        }
    } else {
        die("QUERY CANNOT BE EXECUTED - UPDATE");
    }
}
?>