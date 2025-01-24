<?php
//name Validation
if(preg_match("/^[A-Za-z ]*$/", $_POST["student_name"])) 
{
}
else{

  echo "Give Character only"."<br>";
  $error[]="give character ";
}
//ID Validation 
if(preg_match("/^[0-9]{2}+\-[0-9]{5}+\-[0-9]{1}/", $_POST["student_id"])) 
{
  
}
else{
  echo "Provide xx-yyyyy-z format "."<br>";
  $error[]="give right format";
}
//Email Validation
if (preg_match("/\@+(student)+\.(aiub)+\.(edu)/", $_POST['email'])) {

  
}else {
  echo "provide right format"."<br>";
  $error[]="Provide right format";
}
//Book Title Validation

if (!empty($_POST['book_title'])){
  
      
}else {
  echo "No Book Selected!"."<br>";
  $error[]="No Book Selected";
}
//Borrow Date & Return Date Validation

if (empty($_POST["borrow_date"])) {
    echo "Select Borrow Date"."<br>";
    $error[] = "Borrow Date is required.";
} else {
    $borrow_date = $_POST["borrow_date"];
}

if (empty($_POST["return_date"])) {
  echo "Select Return Date"."<br>";
    $error[] = "Return Date is required.";
} else {
    $return_date = $_POST["return_date"];
}

// Check for 10-day gap
if (!empty($borrow_date) && !empty($return_date)) {
    $borrow_date_obj = new DateTime($borrow_date);
    $return_date_obj = new DateTime($return_date);
    $date_diff = $borrow_date_obj->diff($return_date_obj)->days;
    if ($return_date_obj <= $borrow_date_obj) {
        $error[] = "Return Date must be after the Borrow Date.";
         echo "Return Date Must be after the Borrow Date"."<br>";
    } elseif ($date_diff < 10) {
        $error[] = "There must be at least a 10-day gap between Borrow Date and Return Date.";
         echo "There Must be at least a 10 days gap"."<br>";
    }
    
}
//TOken Validation


$jsonFile = 'token.json';

$useTokenFile = 'useToken.json';

if (preg_match("/^[0-9]+$/", $_POST["token"])) {

    $inputToken = $_POST["token"];

    if (file_exists($jsonFile)) {

        // Read token.json

        $validTokens = json_decode(file_get_contents($jsonFile), true)['tokens'] ?? [];

        if (in_array($inputToken, $validTokens)) {

            // Check useToken.json

            $usedTokens = file_exists($useTokenFile) ? json_decode(file_get_contents($useTokenFile), true) : [];

            if (in_array($inputToken, $usedTokens)) {

                echo "<p style='color:red;'>Token {$inputToken} has already been used.</p>";

                $error[] = "Token already used.";

            } else {

                // Save the new token to useToken.json

                $usedTokens[] = $inputToken;

                file_put_contents($useTokenFile, json_encode($usedTokens, JSON_PRETTY_PRINT));

                echo "<p style='color:green;'>Token {$inputToken} validated and saved successfully!</p>";

            }

        } else {

            echo "<p style='color:red;'>Token {$inputToken} is not found in the valid token list.</p>";

            $error[] = "Invalid token.";

        }

    } else {

        echo "<p style='color:red;'>token.json file not found.</p>";

        $error[] = "Token validation failed.";

    }

} else {

    echo "Provide a numeric token.<br>";

    $error[] = "Invalid token format.";

} 
//FEES Validation

if(preg_match("/^[0-9]/", $_POST["fees"])) 
{
  
}
else{
  echo "provide Number"."<br>";
  $error[]="Provide Number";


}
$book_title= $_POST['book_title'];
$cookie_name = preg_replace('/[^a-zA-Z0-9_\-]/', '', $book_title);
$cookie_value = $_POST['student_name'];

if(empty($error)){
if (isset($_COOKIE[$cookie_name])) {
  echo " The Book is Not Available.You Can not Borrow this Book";
} else {
  setcookie($cookie_name, $cookie_value,time()+15);
  echo "RECIEPT"."<br><br>";
  echo "STUDENT FULL NAME:". $_POST['student_name']."<br>";
  echo "STUDENT ID:".$_POST['student_id']."<br>";
  echo "STUDENT Email:".$_POST['email']."<br>";
  echo "BOOK TITLE:".$_POST['book_title']."<br>";
  echo "BORROW DATE:".$_POST['borrow_date']."<br>";
  echo "TOKEN".$_POST['token']."<br>";
  echo "RETURN DATE:".$_POST['return_date']."<br>";
  echo "FEES:". $_POST['fees']."<br>";
  

}
}
$jsonFile = 'token.json';

// Handle form submission

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $inputToken = $_POST['token']; // Get the token from the form input

    // Check if token.json exists and read tokens

    if (file_exists($jsonFile)) {

        $data = json_decode(file_get_contents($jsonFile), true);

        if (isset($data['tokens']) && is_array($data['tokens'])) {

            // Check if input token matches a token in the list

     if (in_array($inputToken, $data['tokens'])) {

                // Save the matched token to useToken.json

                $useTokenFile = 'useToken.json';

                $usedTokens = [];

                // Read existing used tokens if the file exists

                $usejsonFile = 'useToken.json';

                if (file_exists($useTokenFile)) {

                    $usedTokens = json_decode(file_get_contents($useTokenFile), true);

                }

                // Add the new token

                $usedTokens[] = $inputToken;

                // Save back to useToken.json

                file_put_contents($useTokenFile, json_encode($usedTokens, JSON_PRETTY_PRINT));

                echo "saved successfully";

            } else {

                echo "Token not found in the token list";

            }

        } else {

            //echo "<p style='color:red; text-align:center;'>Token list is empty.</p>";

        }

    } else {

       // echo "<p style='color:red; text-align:center;'>token.json file not found.</p>";

    }

} 
  

?>

