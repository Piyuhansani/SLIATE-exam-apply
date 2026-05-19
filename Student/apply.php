<?php
//Add connection
include "../DBConnection/connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    
    <!-- CSS link -->
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../stylenav.css">
    
</head>
<body>

        <!-- Profile Icon and Dropdown -->
        <div class="nav-container">
        <nav>
            <img src="../Images/images.png" class="logo" alt="logo">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">About</a></li>
            </ul>
            <img src="../Images/profile-user.png" class="user-pic" onclick="togglemenu();">
            <div class="sub-menu-wrap" id="sub-menu-wrap">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="../Images/profile-user.png">
                        <h1>User Name</h1>
                    </div>
                    <hr>
                    <a href="#" class="sub-menu-link">
                        <img src="../Images/user-avatar.png">
                        <p>Edit Profile</p>
                        <span></span>
                    </a>
                    <a href="#" class="sub-menu-link">
                        <img src="../Images/setting.png">
                        <p>Setting</p>
                        <span></span>
                    </a>
                    <a href="#" class="sub-menu-link">
                        <img src="../Images/help-web-button.png">
                        <p>Help</p>
                        <span></span>
                    </a>
                    <a href="login.php" class="sub-menu-link">
                        <img src="../Images/logout.png">
                        <p>Log Out</p>
                        <span></span>
                    </a>
                </div>
            </div>
        </nav>



    <div class="heading">
        <h1 id="title">Sri Lanka Institute of Advanced Technological Education Examination - <span id="currentYear"></span></h1>
        <h2>Semester - I<br>Application Form</h2>
    </div>

       <!-- Acadamic Details Section -->
    <div class="Academic-Details">
    <h3 style="padding-left:5px; font-size:20px;">Academic Details</h3>

    <form action="" method="post">
    <div class="form-container">
    <label for="course_name">Name of the course :</label>
    <input type="text" id="course_name" name="course_name" spellcheck="false" placeholder="Enter Your course Name" required>

    <label for="academic_year">Academic year :</label>
    <select id="academic_year" name="academic_year" required>
        <option value="" disabled selected>Academic Year</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>

    <label for="reg_number">Registration Number :</label>
    <input type="text" id="reg_number" name="reg_number" spellcheck="false" placeholder="Enter Your Registration Number" required>

    <label for="index_no">Index No :</label>
    <input type="text" id="index_no" name="index_no" spellcheck="false" placeholder="Enter Your Index Number" required>

    <label for="semester">Semester :</label>
    <select id="semester" name="semester" required>
        <option value="" disabled selected>Semester</option>
        <option value="I">I</option>
        <option value="II">II</option>
        <option value="III">III</option>
        <option value="IV">IV</option>
    </select>
</div>

        <div class="center-container">

        <select id="Subjects" name="Subjects" class="Subjects-input-field" required>
            <option value="" disabled selected>Select Your Subjects</option>
            <option value="AG1208">AG1208 - Field Crop Production</option>
            <option value="AG1209">AG1209 - Protective Crop Production & Floriculture</option>
            <option value="AG1210">AG1210 - Soil Science</option>
            <option value="MG2101">MG2101 - Business Management</option>
        </select>
        <br><br>
        <ul id="selected-subjects" class="subject-list"></ul>
    </div>
    <div>
        <button type="submit" name="apply" id="apply_btn">Apply</button>
    </div>
    </form>
</div>    

<script src="script.js"></script>

</body>
</html>


<?php
if(isset($_POST["apply"])){
    $course_name = $_POST["course_name"];
    $academic_year = $_POST["academic_year"];
    $reg_number = $_POST["reg_number"];
    $index_no = $_POST["index_no"];
    $semester = $_POST["semester"];
    $Division = $_POST["Division"];
    $Subjects = $_POST["Subjects"];

//checking 
$sql1="SELECT * FROM student WHERE Registration_number='$reg_number'";
$result1=$conn->query($sql1);
if($result1->num_rows > 0) {
    echo "<script>alert('You are already Apply!')</script>";
}else{
//inserting 
$sql2 = "INSERT INTO `studentapply`(`Registration_number`,`course_name`,`semester`,
`academic_year`,`index_number`,`devision_name`,`subject`) 
        VALUES('$reg_number','$course_name','$semester','$academic_year','$index_no','$Division',
        '$Subjects')";

$result2=$conn->query($sql2);

if($result2){
    echo "<script>alert('You successfully apply')</script>";
}}
}

//closing connection
$conn->close();
?>