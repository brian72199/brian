<?php include 'header.php'; ?>

    <!-- MAIN CONTENT GOES HERE -->
    <div class="main">
        <div class="container-fluid my-3">
            <h2 class="my-3 py-2"> User Management</h2>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-user-plus"></i> Add User 
                        </button>
                    </div>
                    <div class="col-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
                    </div>
                </div>
                <div id="userTable">    
                    <!-- Content goes here -->
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Pagination items will be added dynamically here -->
                    </ul>
                </nav>  
        </div>
    </div>


    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addUserForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="addFirstname">Firstname</label>
                            <input type="text" class="form-control" id="addFirstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="addLastname">Lastname</label>
                            <input type="text" class="form-control" id="addLastname" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="addAddress">Address</label>
                            <input type="text" class="form-control" id="addAddress" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="addBirthdate">Birthdate</label>
                            <input type="date" class="form-control" id="addBirthdate" name="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label for="addEmail">Email</label>
                            <input type="email" class="form-control" id="addEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="addUsername">Username</label>
                            <input type="text" class="form-control" id="addUsername" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="addPassword">Password</label>
                            <input type="password" class="form-control" id="addPassword" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm">
                    <div class="modal-body">
                    <input type="hidden" name="user_id" id="editUserId">
                        <div class="form-group">
                            <label for="editFirstname">Firstname</label>
                            <input type="text" class="form-control" id="editFirstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="editLastname">Lastname</label>
                            <input type="text" class="form-control" id="editLastname" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="editBirthdate">Birthdate</label>
                            <input type="date" class="form-control" id="editBirthdate" name="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editUsername">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="editPassword">Password</label>
                            <input type="text" class="form-control" id="editPassword" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let totalPages = 1;

            function fetchUsers(searchQuery = '', page = 1) {
                $.ajax({
                    url: 'models/getAllUsers.php',
                    type: 'GET',
                    data: { search: searchQuery, page: page },
                    dataType: 'json',
                    success: function(response) {
                        let data = response.data;
                        totalPages = Math.ceil(response.total_count / 10);
                        if (data.length > 0) {
                            var tableHTML = '<table class="table table-striped text-center"><thead><tr><th>User ID</th><th>Firstname</th><th>Lastname</th><th>Address</th><th>Birthdate</th><th>Email</th><th>Username</th><th>Actions</th></tr></thead><tbody>';
                            
                            $.each(data, function(index, user) {
                                tableHTML += '<tr>';
                                tableHTML += '<td>' + user.user_id + '</td>';
                                tableHTML += '<td>' + user.firstname + '</td>';
                                tableHTML += '<td>' + user.lastname + '</td>';
                                tableHTML += '<td>' + user.address + '</td>';
                                tableHTML += '<td>' + user.birthdate + '</td>';
                                tableHTML += '<td>' + user.email + '</td>';
                                tableHTML += '<td>' + user.username + '</td>';
                                tableHTML += '<td><button class="btn btn-primary btn-sm btn-edit" data-user_id="' + user.user_id + '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm btn-delete" data-user_id="' + user.user_id + '"><i class="fas fa-trash-alt"></i> Delete</button></td>';
                                tableHTML += '</tr>';
                            });

                            tableHTML += '</tbody></table>';
                            $('#userTable').html(tableHTML);
                            updatePagination(page, totalPages);
                        } else {
                            $('#userTable').html('<p>No users found.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching users:', error);
                        $('#userTable').html('<p>Error fetching users.</p>');
                    }
                });
            }
            function updatePagination(currentPage, totalPages) {
                let paginationHTML = '';

                paginationHTML += '<li class="page-item' + (currentPage === 1 ? ' disabled' : '') + '">';
                paginationHTML += '<a class="page-link" href="#" aria-label="Previous" data-page="' + (currentPage - 1) + '">';
                paginationHTML += '<span aria-hidden="true">&laquo;</span>';
                paginationHTML += '</a></li>';

                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += '<li class="page-item' + (i === currentPage ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }

                paginationHTML += '<li class="page-item' + (currentPage === totalPages ? ' disabled' : '') + '">';
                paginationHTML += '<a class="page-link" href="#" aria-label="Next" data-page="' + (currentPage + 1) + '">';
                paginationHTML += '<span aria-hidden="true">&raquo;</span>';
                paginationHTML += '</a></li>';

                $('#pagination').html(paginationHTML);
            }

            $('#pagination').on('click', 'a', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                if (page && page !== currentPage && page <= totalPages && page >= 1) {
                    currentPage = page;
                    fetchUsers($('#searchInput').val(), currentPage);
                }
            });

            $('#searchInput').on('keyup', function() {
                currentPage = 1;
                fetchUsers($(this).val(), currentPage);
            });

            fetchUsers(); // Initial fetch
            
            // Add User form submission handler
            $('#addUserForm').submit(function(event) {
                event.preventDefault();

                var formData = {
                    firstname: $('#addFirstname').val(),
                    lastname: $('#addLastname').val(),
                    address: $('#addAddress').val(),
                    birthdate: $('#addBirthdate').val(),
                    email: $('#addEmail').val(),
                    username: $('#addUsername').val(),
                    password: $('#addPassword').val()
                };

                $.ajax({
                    url: 'models/addUser.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.statusCode === 200) {
                            alert(response.message);
                            $('#addUserModal').modal('hide');
                            $('#addUserForm')[0].reset(); // Clear form fields
                            location.reload(); // Reload the page
                        } else {
                            alert('Failed to add user: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding user:', error);
                        alert('Error adding user. Please try again later.');
                    }
                });
            });

            // Edit button click handler
            $(document).on('click', '.btn-edit', function() {
                var user_id = $(this).data('user_id');

                // Fetch user details for editing
                $.ajax({
                    url: 'models/getUser.php',
                    type: 'GET',
                    data: { user_id: user_id },
                    dataType: 'json',
                    success: function(user) {
                        // Populate edit form with user details
                        $('#editUserId').val(user.user_id); // Corrected line
                        $('#editFirstname').val(user.firstname);
                        $('#editLastname').val(user.lastname);
                        $('#editAddress').val(user.address);
                        $('#editBirthdate').val(user.birthdate);
                        $('#editEmail').val(user.email);
                        $('#editUsername').val(user.username);
                        $('#editPassword').val(user.password);

                        // Show the edit modal
                        $('#editUserModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching user details:', error);
                        alert('Error fetching user details. Please try again later.');
                    }
                });
            });

            // Edit user form submission handler
            $('#editUserForm').submit(function(event) {
                event.preventDefault();

                var formData = {
                    user_id: $('#editUserId').val(),
                    firstname: $('#editFirstname').val(),
                    lastname: $('#editLastname').val(),
                    address: $('#editAddress').val(),
                    birthdate: $('#editBirthdate').val(),
                    email: $('#editEmail').val(),
                    username: $('#editUsername').val(),
                    password: $('#editPassword').val()
                };

                $.ajax({
                    url: 'models/updateUser.php',
                    type: 'PUT',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.statusCode === 200) {
                            alert(response.message);
                            $('#editUserModal').modal('hide');
                            fetchUsers(); // Refresh user table
                        } else {
                            alert('Failed to update user: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating user:', error);
                        alert('Error updating user. Please try again later.');
                    }
                });
            });

            // Delete button click handler
            $(document).on('click', '.btn-delete', function() {
                var user_id = $(this).data('user_id');

                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: 'models/deleteUser.php',
                        type: 'DELETE',
                        data: JSON.stringify({ user_id: user_id }),
                        dataType: 'json',
                        contentType: 'application/json',
                        success: function(response) {
                            if (response.statusCode === 200) {
                                alert(response.message);
                                fetchUsers(); // Refresh user table
                            } else {
                                alert('Failed to delete user: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting user:', error);
                            alert('Error deleting user. Please try again later.');
                        }
                    });
                }
            });
        });

    </script>


<?php include 'footer.php'; ?>