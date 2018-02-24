<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FanfiBook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>

    <style>

    fieldset{
        border: 1px solid;
        width: 48%;

    }

     input[type=submit]{

         background-color: #0000CD;
         color: white;
         padding: 12px;
         margin: 10px;
         border-radius: 3px;
         border: none;
     }

     input[type=submit]:hover{
         background-color: #00008B;

     }

     input[type=text],[type=password]{
         background-color: whitesmoke;
         padding: 8px;
         margin: 2px;
         border-radius: 4px;
         box-sizing: border-box;

     }
    </style>

    <script>
        function changeState(checkboxID) {

        
        var checkbox = document.getElementById("isregistered");
        var firstname = document.getElementById("firstname");
        var lastname = document.getElementById("lastname");
        var mail = document.getElementById("mail");
        var submitbutton = document.getElementById("submitbutton");
        var hidden = document.getElementById('hiddenCheckbox')
        //updateToggle = checkbox.checked ? toggle.disabled=true : toggle.disabled=false;
        if(checkbox.checked){
            firstname.disabled=true;
            firstname.value="-Not required for login-";
            firstname.style.backgroundColor="#D3D3D3";

            lastname.disabled=true;
            lastname.value="-Not required for login-";
            lastname.style.backgroundColor="#D3D3D3";

            mail.disabled=true;
            mail.style.backgroundColor="#D3D3D3";
            mail.value="-Not required for login-";
            submitbutton.value="Login";
            hidden.disabled = "true";
        }else{
            firstname.disabled=false;
            firstname.style.backgroundColor="whitesmoke";
            firstname.value="";

            lastname.disabled=false;
            lastname.style.backgroundColor="whitesmoke";
            lastname.value="";

            mail.disabled=false;
            mail.style.backgroundColor="whitesmoke";
            mail.value="";
            submitbutton.value="Register";
            hidden.disabled = "false";
        }
        }
    </script>

</head>
<body  background="https://hbee178.files.wordpress.com/2013/06/white-blue-effect-backgrounds-for-powerpoint.jpg?" style="background-size:cover">


<?php
session_start();
    if(isset($_GET['register_user'])){

        $alreadyregistered = $_POST['alreadyregistered'];

        if($alreadyregistered == "true"){
            $password = $_POST['password'];
            $username = $_POST['username'];

            $servername = "localhost";
            $un = "root";
            $pw = "";
            $dbname = "project_webeng";

            // Create connection
            $conn = new mysqli($servername, $un, $pw, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            $sql = "SELECT username, password FROM logindata where username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo  "Name: " . $row["username"].  " Password: " . $row["password"] .  "<br>";
                    if(password_verify($password, $row["password"])){
                        echo "Maching";
                        $_SESSION['userid'] = $row["username"];
                        header( 'Location: geheim.php' ) ;
                    }else{
                        echo "Not Matching";
                        
                    }
                }
            } else {
                echo "0 results";
            }
            $conn->close();

        }else if($alreadyregistered == "false"){
      
            $mail = $_POST['mail'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $username = $_POST['username'];

            $servername = "localhost";
            $un= "root";
            $pw = "";
            $dbname = "project_webeng";

            $conn = new mysqli($servername, $un, $pw, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO logindata (firstname, lastname, password, mail, username)
VALUES ('$firstname', '$lastname', '$password', '$mail', '$username')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

        }

    }

?>


<form action="?register_user" method="POST">
<legend><b>New to this site?</b></legend>
<fieldset>
<table >
<tr>
    <td>User Name: </td>
    <td><input type="text" size="30" name="username"></td>
</tr>
<tr>
    <td>First Name: </td>
    <td><input type="text" size="30" name="firstname" id="firstname"></td>
</tr>
<tr>
<td>Last Name: </td>
    <td><input type="text" size="30" name="lastname" id="lastname"></td>
</tr>
<tr>
    <td>Password: </td>
    <td><input type="password" size="30" name="password"></td>
</tr>
<tr>
    <td>Mail: </td>
    <td><input type="text" size="30" name="mail" id="mail"></td>
</tr>
<tr>
<td colspan="2">
<input type="checkbox" name="alreadyregistered" value="true" onclick="changeState('this')" id="isregistered"> I am already registered.
<input id='hiddenCheckbox' type='hidden' value='false' name='alreadyregistered'>
</td>
</tr>
<tr>
<td colspan="2" "align: right"><input type="submit" value="Register" id="submitbutton"></td>
</tr>
</table>

    </fieldset>
    </form>
</body>
</html>