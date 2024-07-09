<?php include 'header.php'; ?>

    <!-- MAIN CONTENT GOES HERE -->
    <div class="main">
        <div class="container-fluid my-3">
            <h2 class="my-3 py-2">Staff Management</h2>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                            <i class="fas fa-user-plus"></i> Add Staff
                        </button>
                    </div>
                    <div class="col-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search staff...">
                    </div>
                </div>
                <div id="staffTable">
                    <!-- Content goes here -->
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Pagination items will be added dynamically here -->
                    </ul>
                </nav>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addStaffForm">
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
                            <label for="addStaffDescription">Staff Description</label>
                            <input type="text" class="form-control" id="addStaffDescription" name="staff_description" required>
                        </div>
                        <div class="form-group">
                            <label for="addPrivilege">Privilege</label>
                            <input type="text" class="form-control" id="addPrivilege" name="privilege" required>
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
                        <button type="submit" class="btn btn-primary">Add Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStaffForm">
                    <div class="modal-body">
                        <input type="hidden" name="staff_id" id="editStaffId">
                        <div class="form-group">
                            <label for="editFirstname">Firstname</label>
                            <input type="text" class="form-control" id="editFirstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="editLastname">Lastname</label>
                            <input type="text" class="form-control" id="editLastname" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="editStaffDescription">Staff Description</label>
                            <input type="text" class="form-control" id="editStaffDescription" name="staff_description" required>
                        </div>
                        <div class="form-group">
                            <label for="editPrivilege">Privilege</label>
                            <input type="text" class="form-control" id="editPrivilege" name="privilege" required>
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

            function fetchStaffs(searchQuery = '', page = 1) {
                $.ajax({
                    url: 'models/getAllStaffs.php',
                    type: 'GET',
                    data: { search: searchQuery, page: page },
                    dataType: 'json',
                    success: function(response) {
                        let data = response.data;
                        totalPages = Math.ceil(response.total_count / 10);
                        if (data.length > 0) {
                            let tableHTML = '<table class="table table-striped border text-center"><thead><tr><th>Staff ID</th><th>Firstname</th><th>Lastname</th><th>Staff Description</th><th>Username</th><th>Privilege</th><th>Actions</th></tr></thead><tbody>';

                            $.each(data, function(index, staff) {
                                tableHTML += '<tr>';
                                tableHTML += '<td>' + staff.staff_id + '</td>';
                                tableHTML += '<td>' + staff.firstname + '</td>';
                                tableHTML += '<td>' + staff.lastname + '</td>';
                                tableHTML += '<td>' + staff.staff_description + '</td>';
                                tableHTML += '<td>' + staff.username + '</td>';
                                tableHTML += '<td>' + staff.privilege + '</td>';
                                tableHTML += '<td><button class="btn btn-primary btn-sm btn-edit" data-staff_id="' + staff.staff_id + '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm btn-delete" data-staff_id="' + staff.staff_id + '"><i class="fas fa-trash-alt"></i> Delete</button></td>';
                                tableHTML += '</tr>';
                            });

                            tableHTML += '</tbody></table>';
                            $('#staffTable').html(tableHTML);
                            updatePagination(page, totalPages);
                        } else {
                            $('#staffTable').html('<p>No staffs found.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching staffs:', error);
                        $('#staffTable').html('<p>Error fetching staffs.</p>');
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
                    fetchStaffs($('#searchInput').val(), currentPage);
                }
            });

            $('#searchInput').on('keyup', function() {
                currentPage = 1;
                fetchStaffs($(this).val(), currentPage);
            });

            fetchStaffs(); // Initial fetch
            
            // Add Staff form submission handler
            $('#addStaffForm').submit(function(event) {
                event.preventDefault();

                var formData = {
                    firstname: $('#addFirstname').val(),
                    lastname: $('#addLastname').val(),
                    staff_description: $('#addStaffDescription').val(),
                    privilege: $('#addPrivilege').val(),
                    username: $('#addUsername').val(),
                    password: $('#addPassword').val()
                };

                $.ajax({
                    url: 'models/addStaff.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.statusCode === 200) {
                            alert(response.message);
                            $('#addStaffModal').modal('hide');
                            $('#addStaffForm')[0].reset(); // Clear form fields
                            location.reload(); // Reload the page
                        } else {
                            alert('Failed to add staff: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding staff:', error);
                        alert('Error adding staff. Please try again later.');
                    }
                });
            });


            // Edit button click handler
            $(document).on('click', '.btn-edit', function() {
                var staff_id = $(this).data('staff_id');

                // Fetch staff details for editing
                $.ajax({
                    url: 'models/getStaff.php',
                    type: 'GET',
                    data: { staff_id: staff_id },
                    dataType: 'json',
                    success: function(staff) {
                        // Populate edit form with staff details
                        $('#editStaffId').val(staff.staff_id);
                        $('#editFirstname').val(staff.firstname);
                        $('#editLastname').val(staff.lastname);
                        $('#editStaffDescription').val(staff.staff_description);
                        $('#editPrivilege').val(staff.privilege);
                        $('#editUsername').val(staff.username);
                        $('#editPassword').val(staff.password);

                        // Show the edit modal
                        $('#editStaffModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching staff details:', error);
                        alert('Error fetching staff details. Please try again later.');
                    }
                });
            });

            // Edit staff form submission handler
            $('#editStaffForm').submit(function(event) {
                event.preventDefault();

                var formData = {
                    staff_id: $('#editStaffId').val(),
                    firstname: $('#editFirstname').val(),
                    lastname: $('#editLastname').val(),
                    staff_description: $('#editStaffDescription').val(),
                    privilege: $('#editPrivilege').val(),
                    username: $('#editUsername').val(),
                    password: $('#editPassword').val()
                };

                $.ajax({
                    url: 'models/updateStaff.php',
                    type: 'PUT',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.statusCode === 200) {
                            alert(response.message);
                            $('#editStaffModal').modal('hide');
                            fetchStaffs(); // Refresh staff table
                        } else {
                            alert('Failed to update staff: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating staff:', error);
                        alert('Error updating staff. Please try again later.');
                    }
                });
            });

            // Delete button click handler
            $(document).on('click', '.btn-delete', function() {
                var staff_id = $(this).data('staff_id');

                if (confirm('Are you sure you want to delete this staff?')) {
                    $.ajax({
                        url: 'models/deleteStaff.php',
                        type: 'DELETE',
                        data: JSON.stringify({ staff_id: staff_id }),
                        dataType: 'json',
                        contentType: 'application/json',
                        success: function(response) {
                            if (response.statusCode === 200) {
                                alert(response.message);
                                fetchStaffs(); // Refresh staff table
                            } else {
                                alert('Failed to delete staff: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting staff:', error);
                            alert('Error deleting staff. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>

<?php include 'footer.php'; ?>