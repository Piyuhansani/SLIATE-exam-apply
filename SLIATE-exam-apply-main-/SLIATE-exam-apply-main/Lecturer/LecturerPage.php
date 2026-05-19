<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Page</title>

    <!-- CSS link -->
    <link rel="stylesheet" href="../style2.css">
    <link rel="stylesheet" href="../stylenav.css">

</head>
<body>

                <!-- Profile Icon and Dropdown -->
                <div class="nav-container">
        <nav>
            <img src="../Images/images.png" class="logo">
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
                    <a href="#" class="sub-menu-link">
                        <img src="../Images/logout.png">
                        <p>Log Out</p>
                        <span></span>
                    </a>
                </div>
            </div>
        </nav>


    <div class="lecturerOption-container">
        <h1>Lecturer's Page</h1>
        <a href="eligibilityCheck.php" class="button">Eligibility Check</a>
        <a href="viewTimeTable.php" class="button">View Timetable</a>
        <a href="addMarks.php" class="button">Add Marks</a>
    </div>
</div>

    <script src="script.js"></script>

</body>
</html>
