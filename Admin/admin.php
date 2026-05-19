<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

   
     <!-- CSS link -->
     <link rel="stylesheet" href="../style2.css">
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
                    <a href="admin_login.php" class="sub-menu-link">
                        <img src="../Images/logout.png">
                        <p>Log Out</p>
                        <span></span>
                    </a>
                </div>
            </div>
        </nav>
    


    <div class="adminOption-container">
        <h1>Admin's Page</h1>
        <a href="setTimeTable.php" class="button">Set Timetables</a>
        <a href="../Lecturer/LecturerSignup.php" class="button">Create Lecture Logins</a>
        <a href="#" class="button">Get Exam Registration Summaries</a>
        <a href="#" class="button">Get Results Summaries</a>
        <a href="#" class="button">Approvals</a>
    </div>
    
  </div> 

 <script src="script.js"></script>

</body>
</html>