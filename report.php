
<!DOCTYPE html>
<html>

    <head>
        <title>Report</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
        <script src="1Level/validation.js"></script>
    </head>

    <body onload="newCaptcha()">
        <form  action="" method="POST" autocomplete="off">
            <div class="form">

                <h2>(to be filled)</h2>
                <p>(to be filled)</p>

                <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p>
            
                
                <label for="reportedID">User ID to report</label><br>
                <input type="text" id="reportedID" name="reportedID" minlength="32" maxlength="32" required >
                <!--<a href="resetpassword.php" style="text-decoration:none; font-size: 15px;">Forgot Password?</a><br><br> -->

                <label for="description">Description of Report</label><br>
                <textarea id="description" name="description" required rows-"10" cols="50" ></textarea>
                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
                <input type="text"  id="captcha" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

                <!-- Below validate captcha is not working. -->
                <button type="submit" onclick="return validCaptcha()" name="submit" id="submit-button">Login</button>
                

                <script>
                    function validCaptcha(){ 
                        var captcha = document.getElementById('captcha').value ; 
                        var enteredCaptcha = document.getElementById('enteredCaptcha').value ; 
                        
                        if( enteredCaptcha == '' ){ 
                            alert("Enter the captcha.") ; 
                            return false ; 
                        }
                        else if( captcha != enteredCaptcha ){ 
                            alert("Wrong captcha Try again.") ; 
                            return false ; 
                        }
                    }
                </script>
            </div> 
        </form>
    </body>
</html>