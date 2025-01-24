<?php
// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'book information';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<p style='text-align: center; color: red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data and sanitize it
    $ISBN = trim($_POST['ISBN']);
    $BookName = isset($_POST['BookName']) ? trim($_POST['BookName']) : null;
    $AuthorName = isset($_POST['AuthorName']) ? trim($_POST['AuthorName']) : null;
    $Price = isset($_POST['Price']) ? trim($_POST['Price']) : null;
    $NumberOfCopies = isset($_POST['NumberOfCopies']) ? trim($_POST['NumberOfCopies']) : null;

    // Validate ISBN
    if (empty($ISBN)) {
        echo "<p style='text-align: center; color: red;'>ISBN is required to update the book!</p>";
    } else {
        // Build the dynamic SQL query
        $fields = [];
        $params = [];
        $types = "";

        if (!empty($BookName)) {
            $fields[] = "BookName = ?";
            $params[] = $BookName;
            $types .= "s";
        }
        if (!empty($AuthorName)) {
            $fields[] = "AuthorName = ?";
            $params[] = $AuthorName;
            $types .= "s";
        }
        if (!empty($Price)) {
            if (!is_numeric($Price) || $Price <= 0) {
                echo "<p style='text-align: center; color: red;'>Price must be a positive number!</p>";
                exit;
            }
            $fields[] = "Price = ?";
            $params[] = $Price;
            $types .= "d";
        }
        if (!empty($NumberOfCopies)) {
            if (!is_numeric($NumberOfCopies) || $NumberOfCopies < 0) {
                echo "<p style='text-align: center; color: red;'>Book copies must be a non-negative integer!</p>";
                exit;
            }
            $fields[] = "NumberOfCopies = ?";
            $params[] = $NumberOfCopies;
            $types .= "i";
        }

        if (empty($fields)) {
            echo "<p style='text-align: center; color: red;'>No fields to update!</p>";
            exit;
        }

        // Check if the record exists
        $check_sql = "SELECT * FROM bookinformation WHERE ISBN = ?";
        $stmt = $conn->prepare($check_sql);
        if (!$stmt) {
            die("<p style='text-align: center; color: red;'>SQL Error: " . $conn->error . "</p>");
        }

        $stmt->bind_param("s", $ISBN);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Prepare dynamic update query
            $update_sql = "UPDATE bookinformation SET " . implode(", ", $fields) . " WHERE ISBN = ?";
            $update_stmt = $conn->prepare($update_sql);
            if (!$update_stmt) {
                die("<p style='text-align: center; color: red;'>SQL Error: " . $conn->error . "</p>");
            }

            // Bind parameters dynamically
            $params[] = $ISBN; // Add ISBN at the end
            $types .= "s";
            $update_stmt->bind_param($types, ...$params);

            // Execute the statement
            if ($update_stmt->execute()) {
                echo "<p style='text-align: center; color: green;'>Book information updated successfully!</p>";
            } else {
                echo "<p style='text-align: center; color: red;'>Error updating book: " . $update_stmt->error . "</p>";
            }

            $update_stmt->close();
        } else {
            echo "<p style='text-align: center; color: red;'>No book found with ISBN: $ISBN.</p>";
        }

        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>

 
 
 
 