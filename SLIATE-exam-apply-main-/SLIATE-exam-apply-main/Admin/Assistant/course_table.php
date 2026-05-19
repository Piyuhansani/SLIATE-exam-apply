<?php
// Include database connection
include "../../DBConnection/connect.php";

// Fetch all courses from the database
$sql = "SELECT * FROM course";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #f4f4f4; }
        .container { margin-top: 20px; }
        .save-row, .insert-row { display: inline-block; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Course Management</h1>
        <!-- Add New Course Form -->
        <div class="mb-4">
            <button class="btn btn-success" id="addNewCourse">Add New Course</button>
        </div>

        <!-- Table to Display and Manage Courses -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Division Name</th>
                    <th>Academic Year</th>
                    <th>Semester</th>
                    <th>Batch</th>
                    <th>Total Credits</th>
                    <th>Department</th>
                    <th>Included Subjects</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="courseTable">
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr data-course-id="<?php echo $row['course_ID']; ?>">
                    <td><?php echo $row['course_ID']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['course_code']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['course_name']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['division_name']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['academic_year']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['semester']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['batch']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['total_credits']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['department']; ?></td>
                    <td contenteditable="true" class="edit-cell"><?php echo $row['included_subjects']; ?></td>
                    <td>
                        <button class="btn btn-primary save-row">Save</button>
                        <button class="btn btn-danger delete-row">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript for Dynamic Interactions -->
    <script>
        // Save updated row to the database
        $(document).on("click", ".save-row", function () {
            const row = $(this).closest("tr");
            const courseID = row.data("course-id");
            const data = {
                course_ID: courseID,
                course_code: row.find("td").eq(1).text().trim(),
                course_name: row.find("td").eq(2).text().trim(),
                division_name: row.find("td").eq(3).text().trim(),
                academic_year: row.find("td").eq(4).text().trim(),
                semester: row.find("td").eq(5).text().trim(),
                batch: row.find("td").eq(6).text().trim(),
                total_credits: row.find("td").eq(7).text().trim(),
                department: row.find("td").eq(8).text().trim(),
                included_subjects: row.find("td").eq(9).text().trim(),
            };

            // AJAX to Update Course
            $.ajax({
                url: "update_course.php",
                type: "POST",
                data: data,
                success: function (response) {
                    alert(response.trim());
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });

        // Delete row from the database
        $(document).on("click", ".delete-row", function () {
            const row = $(this).closest("tr");
            const courseID = row.data("course-id");

            if (confirm(`Are you sure you want to delete course ID ${courseID}?`)) {
                // AJAX to Delete Course
                $.ajax({
                    url: "delete_course.php",
                    type: "POST",
                    data: { course_ID: courseID },
                    success: function (response) {
                        alert(response.trim());
                        row.remove();
                    },
                    error: function (xhr) {
                        console.error("Error:", xhr.responseText);
                    }
                });
            }
        });

        // Add new row to the table
        $("#addNewCourse").on("click", function () {
            const newRow = `
                <tr>
                    <td>Auto</td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td><button class="btn btn-primary insert-row">Insert</button></td>
                </tr>`;
            $("#courseTable").append(newRow);
        });

        // Insert new row into the database
        $(document).on("click", ".insert-row", function () {
            const row = $(this).closest("tr");
            const data = {
                course_code: row.find("td").eq(1).text().trim(),
                course_name: row.find("td").eq(2).text().trim(),
                division_name: row.find("td").eq(3).text().trim(),
                academic_year: row.find("td").eq(4).text().trim(),
                semester: row.find("td").eq(5).text().trim(),
                batch: row.find("td").eq(6).text().trim(),
                total_credits: row.find("td").eq(7).text().trim(),
                department: row.find("td").eq(8).text().trim(),
                included_subjects: row.find("td").eq(9).text().trim(),
            };

            // AJAX to Insert New Course
            $.ajax({
                url: "insert_course.php",
                type: "POST",
                data: data,
                success: function (response) {
                    alert(response.trim());
                    location.reload(); // Reload the page to fetch new data
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>
