<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'MultipleChoiceTestWebsite';

$conn = new mysqli($servername, $username, $password);

if ($conn->error) {
    die("Connection fail: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if (!$conn->query($sql) === TRUE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);
$conn->set_charset('utf8mb4');

$sql = "CREATE TABLE IF NOT EXISTS UserTbl(
    UserId int auto_increment primary key,
    Username nvarchar(100) not null unique,
    UserPassword nvarchar(100) not null,
    UserType nvarchar(100) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($sql) === TRUE) {
    die("Error creating table: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS UserDetailsTbl(
    UserDetailsId int auto_increment primary key,
    UserId int not null,
    UserFullname nvarchar(100) not null,
    UserPhone nvarchar(20),
    UserEmail nvarchar(100) not null,
    UserSchool nvarchar(100), 
    UserAvatar nvarchar(100),
    FOREIGN KEY (UserId) REFERENCES UserTbl(UserId) ON DELETE CASCADE
)";

if (!$conn->query($sql) === TRUE) {
    die("Error creating table: " . $conn->error);
}
