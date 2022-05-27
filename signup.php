<?php

$error = NULL ;

if( isset($_POST['Signup'])){

    $name = $_POST['name'] ;
    $gender = $_POST['gender'] ;
    $aadhaar = $_POST['aadhaar'] ;
    $dOB = $_POST['dOB'] ;
    $pincode = $_POST['pincode'] ;
    $phoneNumber = $_POST['phoneNumber'] ;
    $password = $_POST['password'] ;
    $repeatPassword = $_POST['repeatPassword'] ;
    $userType = $_POST['userType'] ;

    if( $password != $repeatPassword ){
        $error .= "<p>Password don't match</p>"
    }else{
        //form is valid

        $mysqli = NEW MySQLi('localhost','user','','hyre') ;

        //Let's sanitize
        $name = $mysqli->real_escape_string($name) ;
        $gender = $mysqli->real_escape_string($gender) ;
        $aadhaar = $mysqli->real_escape_string($aadhaar) ;
        $dOB = $mysqli->real_escape_string($dOB) ;
        $pincode = $mysqli->real_escape_string($pincode) ;
        $phoneNumber = $mysqli->real_escape_string($phoneNumber) ;
        $password = $mysqli->real_escape_string($password) ;
        $repeatPassword = $mysqli->real_escape_string($repeatPassword) ;
        $userType = $mysqli->real_escape_string($usertType);

        $ID = md5($aadhaar) ;
        $password = md5($password) ;
        $insert = $mysqli->query("INSERT INTO account values('$name','$phoneNumber','$gender','$dOB','$pincode','$aadhaar','$password','$userType','$ID',0,0)")

        if( ! $insert )
            $error .= "<p>Couldn't create account.</p>" ;

    }
    echo $error ;


}


?>

<!DOCTYPE html>

<html>

<head>
    <style>
        table,
        td,
        th {
            text-align: center;
            border: 3px solid black;
            border-collapse: collapse;
            padding: 10px;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <title>signup</title>
</head>

<body>
    <form method="POST" action="">
        <table class="center">
            <tr>
                <td><label for="name">Last Name</label></td>
                <td><input type="text" name="name" id="name" required></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <input type="radio" id="male" name="gender" required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender">
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender">
                    <label for="other">Other</label>
                </td>
            </tr>
            <tr>
                <td>User Type</td>
                <td>
                    <input type="radio" id="client" name="userType" required>
                    <label for="client">Client</label>
                    <input type="radio" id="worker" name="userType">
                    <label for="worker">Worker</label>
                </td>
            </tr>
            <tr>
                <td><label for="aadhaar">Aadhaar</label></td>
                <td><input type="number" name="aadhaar" min="1000000000000000" max="9999999999999999" id="aadhaar" required></td>
            </tr>
            <tr>
                <td><label for="dOB">Date Of Birth</label></td>
                <td><input type="date" name="dOB" id="dOB" required></td>
            </tr>
            <tr>
                <td><label for="pincode">Pincode</label></td>
                <td><input type="number" name="pincode" id="pincode" min="100000" max="999999" required></td>
            </tr>
            <tr>
                <td><label for="phoneNumber">Phone Number</label></td>
                <td><input type="number" name="phoneNumber" id="phoneNumber" min="1000000000" max="9999999999" required></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td><input type="password" name="password" id="password" minlength="8" required></td>
            </tr>
            <tr>
                <td><label for="repeatPassword">Repeat Password</label></td>
                <td><input type="password" name="repeatPassword" id="repeatPassword" minlength="8" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" id="signup" value="Signup"></td>
            </tr>
        </table>
    </form>
</body>

</html>