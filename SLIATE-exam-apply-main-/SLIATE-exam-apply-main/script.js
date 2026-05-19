

        // Current Year In the Heading
         document.getElementById("currentYear").textContent = new Date().getFullYear();

                   // email validation
                   function showerror() {
                    var emailError = document.getElementById("emailError");
                    var emailField = document.getElementById("emailField");
        
                    // Regular expression to validate email format
                   var emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
        
                    // Check if the email field value matches the pattern
                    if (!emailField.value.match(emailPattern)) {
                        emailError.innerHTML = "Enter a valid email";
                    } else {
                        emailError.innerHTML = ""; // Clear error message if valid
                    }
                }
        
                // Password validation
                function validatePasswords() {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    const passwordError = document.getElementById('passwordError');
            
                    // Regular expression for high-security password
                    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
            
                    // Clear previous error message
                    passwordError.textContent = "";
            
                    // Check if the password meets security requirements
                    if (!passwordRegex.test(password)) {
                        passwordError.textContent =
                            "Password must be at least 8 characters long, contain uppercase, lowercase, a number, and a special character.";
                        return;
                    }
            
                    // Check if passwords match
                    if (password !== confirmPassword) {
                        passwordError.textContent = "Passwords do not match!";
                        return;
                    }
                }
        
                //validate form before submitting
                function validateForm() {
                showerror(); 
                validatePasswords(); 
        
                if (document.getElementById("emailError").innerHTML !== "" || document.getElementById("passwordError").innerHTML !== "") {
                    return false; // Stop form submission if errors have
                }
        
                return true; // Submit form - no errors
                }

                // navigation bar profile menu dropdown
                let submenu = document.getElementById("sub-menu-wrap");

                function togglemenu() {
                submenu.classList.toggle("open-class");
                }



        //applying subject selecting 
        const subjectsDropdown = document.getElementById("Subjects");
        const selectedSubjectsList = document.getElementById("selected-subjects");

        // Event listener for adding a subject
        subjectsDropdown.addEventListener("change", function () {
            const selectedValue = this.value;
            const selectedText = this.options[this.selectedIndex].text;

            // Check if the subject is already in the list
            const existingSubjects = Array.from(selectedSubjectsList.children).map(item => item.querySelector('span').textContent);
            if (existingSubjects.includes(selectedText)) {
                alert("This subject is already selected!");
                return;
            }

            // Create a new list item
            const listItem = document.createElement("li");

            // Add subject name
            const subjectName = document.createElement("span");
            subjectName.textContent = selectedText;

            // Add a remove button
            const removeButton = document.createElement("button");
            removeButton.textContent = "Remove";
            removeButton.addEventListener("click", function () {
                selectedSubjectsList.removeChild(listItem);
            });

            // Append subject name and button to the list item
            listItem.appendChild(subjectName);
            listItem.appendChild(removeButton);

            // Append the list item to the selected subjects list
            selectedSubjectsList.appendChild(listItem);
        });

        



         //Created time table showing function
        function addToTimetable() {
         const date = document.getElementById('date').value;
         const division = document.getElementById('division').value;
         const subject = document.getElementById('subject').value;
         const startTime = document.getElementById('start-time').value;
         const endTime = document.getElementById('end-time').value;

         if (!date || !division || !subject || !startTime || !endTime) {
        alert('Please fill in all fields!');
        return;
         }

         const timetable = document.getElementById('timetable');
         const entry = document.createElement('div');
       entry.className = 'timetable-entry';
       entry.innerHTML = `
        <strong>Date:</strong> ${date} | 
        <strong>Division:</strong> ${division} | 
        <strong>Subject:</strong> ${subject} | 
        <strong>Time:</strong> ${startTime} - ${endTime}
    `;
    timetable.appendChild(entry);

    // Clear inputs
    document.getElementById('date').value = '';
    document.getElementById('division').value = '';
    document.getElementById('subject').value = '';
    document.getElementById('start-time').value = '';
    document.getElementById('end-time').value = '';
}


//to print the time table
function printTimetable() {
    // Create a new window for the print preview
    const timetableContent = document.getElementById("timetable").innerHTML;
    const printWindow = window.open("", "_blank");
    
    // Add content to the new window
    printWindow.document.write(`
        <html>
            <head>
                <title>Print Timetable</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                        padding: 0;
                    }
                    h2 {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .timetable-entry {
                        margin-bottom: 15px;
                        border-bottom: 1px solid #ccc;
                        padding-bottom: 10px;
                    }
                </style>
            </head>
            <body>
                ${timetableContent}
            </body>
        </html>
    `);

    // Print the content
    printWindow.document.close();
    printWindow.print();
}



