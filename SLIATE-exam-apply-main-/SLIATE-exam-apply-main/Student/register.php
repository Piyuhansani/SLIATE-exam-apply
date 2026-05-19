<?php
//Add connection
include "../DBConnection/connect.php";



//Add details
if(isset($_POST['SUBMIT'])){
$title=$_POST['title'];
$fullName=$_POST['fullName'];
$nameWithInitials=$_POST['nameWithInitials'];
$regNumber=$_POST['regNumber'];
$address =$_POST['address'];
$mobile =$_POST['mobile'];
$email =$_POST['email'];
$gender =$_POST['gender'];
$password =$_POST['password'];
$confirmPassword =$_POST['confirmPassword'];
$department =$_POST['department'];

//checking existing customer IDs
$sql1="SELECT * FROM student WHERE Registration_number='$regNumber'";
$result1=$conn->query($sql1);
if($result1->num_rows > 0) {
    echo "<script>alert('You are already signup!')
    window.location.href = 'login.php';
    </script>";
    
}else{
//inserting customers
$sql2 = "INSERT INTO `student`(`Registration_number`,`title`,`Full_Name`,`name_with_initials`,
`gender`,`email`,`contact_number`,`address`,`deparment`,`password`,`confirm_password`) 
        VALUES('$regNumber','$title','$fullName','$nameWithInitials','$gender','$email',
        '$mobile','$address','$department','$password','$confirmPassword')";

$result2=$conn->query($sql2);

if($result2){
    echo "<script>alert('You successfully signup')
    window.location.href = 'login.php';
    </script>";
}}
}

    
    if (isset($_POST['submit'])) {
        $regNumber=$_POST['regNumber'];
        $password =$_POST['password'];

        $sql = "select * from student where Registration_number = '$regNumber' and password = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        
        if($count == 1){  
            header("Location: apply.php");
        }  
        else{  
            echo  '<script>
                        window.location.href = "login.php";
                        alert("Login failed. Invalid username or password!!")
                    </script>';
        }     
    }


//closing connection
$conn->close();
?>
