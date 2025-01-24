<?php

// Database connection details

$host = 'localhost'; // Replace with your database host

$username = 'root'; // Replace with your MySQL username

$password = ''; // Replace with your MySQL password

$dbname = 'book information'; // Database name

// Create a connection

$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

// SQL query to fetch data from book_info table

$sql = "SELECT BookName, AuthorName, ISBN, Price, NumberOfCopies FROM bookinformation";

$result = $conn->query($sql);

?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />


<title>Book library</title>
  </head>
  <body>
    <div class="main">
      <div class="right-box">
      <h3 style="text-align: center;">Used Tokens</h3>
<table>
<thead>
<tr>
</tr>
</thead>
<tbody>
<?php

// Path to the useToken.json file

$useTokenFile = 'useToken.json';

// Function to add a token to useToken.json without duplicates

function saveUniqueToken($token, $useTokenFile) {

    // Check if useToken.json exists and load its content

    $usedTokens = [];

    if (file_exists($useTokenFile)) {

        $usedTokens = json_decode(file_get_contents($useTokenFile), true) ?? [];

    }

    // Check if the token is already in the list

    if (!in_array($token, $usedTokens)) {

        // Add the new token to the list

        $usedTokens[] = $token;

        // Save the updated list back to useToken.json

        file_put_contents($useTokenFile, json_encode($usedTokens, JSON_PRETTY_PRINT));

        echo "<p style='color:green;'>Token {$token} saved successfully!</p>";

    } else {

        echo "<p style='color:orange;'>Token {$token} is already in useToken.json.</p>";

    }

}

if (file_exists($useTokenFile)) {

  $usedTokens = json_decode(file_get_contents($useTokenFile), true);

  // Ensure only unique tokens are shown

  $uniqueTokens = array_unique($usedTokens);

  if (!empty($uniqueTokens)) {

      foreach ($uniqueTokens as $token) {

          echo "<tr><td>" . htmlspecialchars($token) . "</td></tr>";

      }

  } else {

      echo "<tr><td>No token have is used.</td></tr>";

  }

} else {

  echo "<tr><td>useToken.json file not found.</td></tr>";

}

?>
</tbody>
</table> 
      </div>
 
      <div class="main-section">
        <section class="top">
          <div class="box1">
          <h1 style="text-align: center;">Books Information</h1>
<table border="1" cellspacing="0" cellpadding="10" width="80%" align="center">
<thead>
<tr>
<th>Book Name</th>
<th>Author Name</th>
<th>ISBN</th>
<th>Price</th>
<th>Copies Available</th>
</tr>
</thead>
<tbody>
<?php

        // Check if there are rows in the result

        if ($result->num_rows > 0) {

            // Loop through each row and display it in a table row

            while ($row = $result->fetch_assoc()) {

                echo "<tr>";

                echo "<td align='center'>" . htmlspecialchars($row['BookName']) . "</td>";

                echo "<td align='center'>" . htmlspecialchars($row['AuthorName']) . "</td>";

                echo "<td align='center'>" . htmlspecialchars($row['ISBN']) . "</td>";

                echo "<td align='center'>$" . htmlspecialchars($row['Price']) . "</td>";

                echo "<td align='center'>" . htmlspecialchars($row['NumberOfCopies']) . "</td>";

                echo "</tr>";

            }

        } else {

            // If no data, show a message

            echo "<tr><td colspan='5' align='center'>No books found in the database.</td></tr>";

        }

        // Close the connection

        $conn->close();

        ?>
</tbody>
</table> 
          </div>
          <div class="box1">
          <h1 style="text-align: center;">Update Book Information</h1>
<form method="POST" action="update.php">
<div>
<label for="isbn">ISBN:</label>
<input type="text" id="ISBN" name="ISBN"  >
</div>
<div>
<label for="BookName">Book Name:</label>
<input type="text" id="BookName" name="BookName" >
</div>
<div>
<label for="AuthorName">Author Name:</label>
<input type="text" id="author_name" name="AuthorName" >
</div>
<div>
<label for="Price">Price:</label>
<input type="number" step="0.01" id="Price" name="Price" >
</div>
<div>
<label for="NumberOfCopies">Copies Available:</label>
<input type="number" id="NumberOfCopies" name="NumberOfCopies" >
</div>
<button type="submit">Update Book</button>
</form> 
          </div>
          <div class="box1">
          <form action="database.php" method="POST">
<h2 style="text-align: center;">Submit Book Information</h2>
<label for="book_name">Book Name:</label>
<input type="text"  name="book_name" placeholder="Data"> <br>
<label for="author_name">Author_Name:</label>
<input type="text"  name="author_name" placeholder="Data"><br>
<label for="ISBN">ISBN</label>
<input type="text" name ="isbn" placeholder="Data"> <br>
<lable for="Price">Price</label>
<input type="text" name="price" placeholder="Data"><br>
<label for="book_copy">Number of Copy:</label>
<input type="text"  name="book_copy" placeholder="Data"> <br>
<input type="submit" value="Submit" name="submit"> 
</form>
          </div>
        </section>
        <section class="middle">
          <div class="box2"><img src="ai1.JPEG"  width="250" height="200">
          </div>
          <div class="box2">
            <img src="ai2.JPEG"  width="250" height="200">
          </div>
          <div class="box2">
            <img src="ai3.JPEG"  width="250" height="200">
          </div>
        </section>
        <section class="lower">
          <div class="box3-1"><form action="process.php" method="post">
    <label for="student_name">Student Full Name:</label>
   <input type="text"  name="student_name" placeholder="Data"><br>

    <label for="student_id">Student ID:</label>
    <input type="text" name="student_id" placeholder="Data"><br>

    <label for="Email">Email:</label>
    <input type="text" name="email" placeholder="Data"><br>


    <label for="book_title">Book Title:</label>
    <select id="book_title" name="book_title">
      <option value="select">select</option>
      <option value="Programmin in C">Programmin in C</option>
      <option value="Electrical Engineering">Electrical Engineering</option>
      <option value="Principales of Compiler Design">Principales of Compiler Design</option>
      <option value="Introduction to Computers">Introduction to Computers</option>
      <option value="Computer Fundamentals"> Computer Fundamentals</option>
      <option value="Microprocessor Data Hand Book">Microprocessor Data Hand Book</option>
      <option value="System Simulation "> System Simulation</option>
      <option value="Visual Basic Net">Visual Basic Net</option>
      <option value="Digital Logic Design">Digital Logic Design</option>


    </select>
    <label for="borrow_date">Borrow Date:</label>
    <input type="date"  name="borrow_date" placeholder="Data"><br>

    <label for="token">Token:</label>
    <input type="text" name="token" placeholder="Data">

    <label for="return_date">Return Date:</label>
    <input type="date" name="return_date" placeholder="Data">

    <label for="fees">Fees:</label>
    <input type="text"  name="fees" placeholder="Data">

    <input type="submit" value="Submit">
  
    </form>
  </div>
          <div class="box3">
            <h3 align ="center">TOKEN</h3>
<table>
<?php

    // Read the JSON file

    $jsonFile = 'token.json';

    if (file_exists($jsonFile)) {

        $data = json_decode(file_get_contents($jsonFile), true);

        if (isset($data['tokens']) && is_array($data['tokens'])) {

            foreach ($data['tokens'] as $token) {

                echo "<tr><td>{$token}</td></tr>";

            }

        } else {

            echo "<tr><td>Tokens not found</td></tr>";

        }

    } else {

        echo "<tr><td>JSON file not found</td></tr>";

    }

    ?>
</table> 
          </div>
        </section>
      </div>
 
      <div class="left-box"><img src="id.JPEG"  width="100" height="40">

      
      </div>
    
    </div>
  </body>
</html>
 