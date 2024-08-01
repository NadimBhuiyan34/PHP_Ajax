<?php
require 'config.php'; // Include your database connection

$response = array();

// Handle POST request for inserting data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && !isset($_POST['edit1'])) {
    $name = $connection->real_escape_string($_POST['name']);
    $roll = $connection->real_escape_string($_POST['roll']);
    $address = $connection->real_escape_string($_POST['address']);

    $sql = "INSERT INTO students (name, roll, addres) VALUES ('$name', '$roll', '$address')";

    if ($connection->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'New student added successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $connection->error;
    }

    echo json_encode($response);
    $connection->close();
    exit;
}

// Handle POST request for deleting data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !isset($_POST['edit1'])) {
    $id = $connection->real_escape_string($_POST['id']);
    $sql = "DELETE FROM students WHERE id = '$id'";

    if ($connection->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Student deleted successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $connection->error;
    }

    echo json_encode($response);
    $connection->close();
    exit;
}

// Handle POST request for editing data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit1'])) {
    $id = $connection->real_escape_string($_POST['id']);
    $name = $connection->real_escape_string($_POST['name']);
    $roll = $connection->real_escape_string($_POST['roll']);
    $address = $connection->real_escape_string($_POST['address']);

    $sql = "UPDATE students SET name='$name', roll='$roll', addres='$address' WHERE id = $id";

    if ($connection->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Student details updated successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $connection->error;
    }

    echo json_encode($response);
    $connection->close();
    exit;
}

// Handle GET request for fetching data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM students";
    $result = $connection->query($sql);

    $students = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($students);
    $connection->close();
    exit;
}
?>
