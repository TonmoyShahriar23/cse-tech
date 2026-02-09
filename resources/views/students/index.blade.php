<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Include Bootstrap CSS and JS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <h2>Students List</h2>
    @if (session('success'))
        <div class="msg msg-success">{{ session('success') }}</div>
    @endif

    <table id="students-table" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Age</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Students data will be populated here -->
        </tbody>
    </table>

    <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
        Add New Student
    </button>

    <!-- Modal for Edit Student -->
    <div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="studentId"> <!-- Hidden input for studentId -->
                        <div class="form-group">
                            <label for="studentName">Name</label>
                            <input type="text" class="form-control" id="studentName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="studentIdInput">Student ID</label>
                            <input type="text" class="form-control" id="studentIdInput" name="student_id" required>
                        </div>
                        <div class="form-group">
                            <label for="studentAge">Age</label>
                            <input type="number" class="form-control" id="studentAge" name="age" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal for Add Student -->
    <div class="modal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="form-group">
                            <label for="addStudentName">Name</label>
                            <input type="text" class="form-control" id="addStudentName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="addStudentId">Student ID</label>
                            <input type="text" class="form-control" id="addStudentId" name="student_id" required>
                        </div>
                        <div class="form-group">
                            <label for="addStudentAge">Age</label>
                            <input type="number" class="form-control" id="addStudentAge" name="age" required min="1" max="120">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch all students and populate the table
        fetch('/api/students')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#students-table tbody');
                data.forEach(student => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${student.id}</td>
                        <td>${student.name}</td>
                        <td>${student.student_id}</td>
                        <td>${student.age}</td>
                        <td>
                            <button class="edit-btn btn btn-warning btn-sm" data-id="${student.id}" data-name="${student.name}" data-student-id="${student.student_id}" data-age="${student.age}">Edit</button>
                            <button class="delete-btn btn btn-danger btn-sm" data-id="${student.id}">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

        // Edit button click event
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('edit-btn')) {
                const studentId = event.target.getAttribute('data-id');
                const name = event.target.getAttribute('data-name');
                const studentIdValue = event.target.getAttribute('data-student-id');
                const age = event.target.getAttribute('data-age');

                // Set values in modal
                document.getElementById('studentId').value = studentId;
                document.getElementById('studentName').value = name;
                document.getElementById('studentIdInput').value = studentIdValue;
                document.getElementById('studentAge').value = age;

                // Show modal
                $('#editModal').modal('show');
            }
        });

        // Handle Delete button click event
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('delete-btn')) {
                const studentId = event.target.getAttribute('data-id');
                if (confirm("Are you sure you want to delete this student?")) {
                    fetch(`http://127.0.0.1:8000/api/student/delete/${studentId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Student deleted successfully') {
                            alert('Student deleted successfully!');
                            event.target.closest('tr').remove(); // Remove row from table without reloading
                        } else {
                            alert('Error deleting student');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            }
        });

        // Handle Save button click event for inline editing
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('save-btn')) {
                const studentId = event.target.getAttribute('data-id');
                const row = event.target.closest('tr');
                
                // Get the updated values from input fields
                const nameInput = row.querySelector('.student-name');
                const studentIdInput = row.querySelector('.student-id');
                const ageCell = row.querySelector('td:nth-child(4)');
                
                const name = nameInput.value;
                const student_id = studentIdInput.value;
                const age = ageCell.textContent;

                // Validate inputs
                if (!name || !student_id) {
                    alert('Please fill in all required fields (Name and Student ID)');
                    return;
                }

                fetch(`http://127.0.0.1:8000/api/student/update/${studentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        name: name, 
                        student_id: student_id,
                        age: age 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Student updated successfully') {
                        alert('Student updated successfully!');
                        // Update the table row with new values (keep as input fields for continued editing)
                        nameInput.value = name;
                        studentIdInput.value = student_id;
                    } else {
                        alert('Error updating student: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating student');
                });
            }
        });

        // Handle Edit form submission (update student data)
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const studentId = document.getElementById('studentId').value;
            const name = document.getElementById('studentName').value;
            const studentIdValue = document.getElementById('studentIdInput').value;
            const age = document.getElementById('studentAge').value;

            fetch(`http://127.0.0.1:8000/api/student/update/${studentId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    name: name, 
                    student_id: studentIdValue,
                    age: age 
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert('Student updated successfully!');
                $('#editModal').modal('hide'); // Hide modal after successful update
                
                // Update the table row with new values
                const row = document.querySelector(`#students-table tr:has(button[data-id='${studentId}'])`);
                if (row) {
                    row.querySelector('td:nth-child(2)').textContent = name;
                    row.querySelector('td:nth-child(3)').textContent = studentIdValue;
                    row.querySelector('td:nth-child(4)').textContent = age;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Handle Add form submission (create new student)
        document.getElementById('addForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('addStudentName').value;
            const studentId = document.getElementById('addStudentId').value;
            const age = document.getElementById('addStudentAge').value;

            // Validate inputs
            if (!name || !studentId || !age) {
                alert('Please fill in all required fields (Name, Student ID, and Age)');
                return;
            }

                fetch('/api/students', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    name: name, 
                    student_id: studentId,
                    age: age 
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert('Student added successfully!');
                $('#addModal').modal('hide'); // Hide modal after successful creation
                
                // Clear the form
                document.getElementById('addForm').reset();
                
                // Add the new student to the table
                const tableBody = document.querySelector('#students-table tbody');
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${data.id}</td>
                    <td>${data.name}</td>
                    <td>${data.student_id}</td>
                    <td>${data.age}</td>
                    <td>
                        <button class="edit-btn btn btn-warning btn-sm" data-id="${data.id}" data-name="${data.name}" data-student-id="${data.student_id}" data-age="${data.age}">Edit</button>
                        <button class="delete-btn btn btn-danger btn-sm" data-id="${data.id}">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding student');
            });
        });
    </script>
</body>
</html>