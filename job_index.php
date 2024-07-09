<?php include 'header.php'; ?>

    <!-- MAIN CONTENT GOES HERE -->
    <div class="main">
        <div class="container-fluid my-3">
            <h2 class="my-3 py-2">Job Management</h2>
            <div class="row">
                <div class="col">
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addJobModal">
                        <i class="fas fa-plus"></i> Add Job
                    </button>
                </div>
                <div class="col-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search jobs...">
                </div>
            </div>
            <div id="jobTable">
                <!-- Content goes here -->
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center" id="pagination">
                    <!-- Pagination items will be added dynamically here -->
                </ul>
            </nav>
        </div>
    </div>


    <!-- Add Job Modal -->
    <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJobModalLabel">Add Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addJobForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="addJobTitle">Job Title</label>
                            <input type="text" class="form-control" id="addJobTitle" name="job_title" required>
                        </div>
                        <div class="form-group">
                            <label for="addJobDescription">Job Description</label>
                            <textarea class="form-control" id="addJobDescription" name="job_description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="addTrail">Trail</label>
                            <input type="text" class="form-control" id="addTrail" name="trail" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Job Modal -->
    <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJobModalLabel">Edit Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editJobForm">
                    <div class="modal-body">
                        <input type="hidden" name="job_id" id="editJobId">
                        <div class="form-group">
                            <label for="editJobTitle">Job Title</label>
                            <input type="text" class="form-control" id="editJobTitle" name="job_title" required>
                        </div>
                        <div class="form-group">
                            <label for="editJobDescription">Job Description</label>
                            <textarea class="form-control" id="editJobDescription" name="job_description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editTrail">Trail</label>
                            <input type="text" class="form-control" id="editTrail" name="trail" required>
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

            function fetchJobs(searchQuery = '', page = 1) {
                $.ajax({
                    url: 'models/getAllJobs.php',
                    type: 'GET',
                    data: { search: searchQuery, page: page },
                    dataType: 'json',
                    success: function(response) {
                        let data = response.data;
                        totalPages = Math.ceil(response.total_count / 10);
                        if (data.length > 0) {
                            var tableHTML = '<table class="table table-striped border text-center"><thead><tr><th>Job ID</th><th>Job Title</th><th>Job Description</th><th>Trail</th><th>Actions</th></tr></thead><tbody>';

                            $.each(data, function(index, job) {
                                tableHTML += '<tr>';
                                tableHTML += '<td>' + job.job_id + '</td>';
                                tableHTML += '<td>' + job.job_title + '</td>';
                                tableHTML += '<td>' + job.job_description + '</td>';
                                tableHTML += '<td>' + job.trail + '</td>';
                                tableHTML += '<td><button class="btn btn-primary btn-sm btn-edit" data-job_id="' + job.job_id + '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm btn-delete" data-job_id="' + job.job_id + '"><i class="fas fa-trash-alt"></i> Delete</button></td>';
                                tableHTML += '</tr>';
                            });

                            tableHTML += '</tbody></table>';
                            $('#jobTable').html(tableHTML);
                            updatePagination(page, totalPages);
                        } else {
                            $('#jobTable').html('<p>No jobs found.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching jobs:', error);
                        $('#jobTable').html('<p>Error fetching jobs.</p>');
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
                    fetchJobs($('#searchInput').val(), currentPage);
                }
            });

            $('#searchInput').on('keyup', function() {
                currentPage = 1;
                fetchJobs($(this).val(), currentPage);
            });

            fetchJobs(); // Initial fetch

        // Add Job form submission handler
        $('#addJobForm').submit(function(event) {
            event.preventDefault();

            var formData = {
                job_title: $('#addJobTitle').val(),
                job_description: $('#addJobDescription').val(),
                trail: $('#addTrail').val()
            };

            $.ajax({
                url: 'models/addJob.php',
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.statusCode === 200) {
                        alert(response.message);
                        $('#addJobModal').modal('hide');
                        $('#addJobForm')[0].reset(); // Clear form fields
                        location.reload(); // Reload the page
                        fetchJobs(); // Refresh job table
                    } else {
                        alert('Failed to add job: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error adding job:', error);
                    alert('Error adding job. Please try again later.');
                }
            });
        });

        // Edit button click handler
        $(document).on('click', '.btn-edit', function() {
            var job_id = $(this).data('job_id');

            // Fetch job details for editing
            $.ajax({
                url: 'models/getJob.php',
                type: 'GET',
                data: { job_id: job_id },
                dataType: 'json',
                success: function(job) {
                    // Populate edit form with job details
                    $('#editJobId').val(job.job_id); // Ensure correct assignment of job_id
                    $('#editJobTitle').val(job.job_title);
                    $('#editJobDescription').val(job.job_description);
                    $('#editTrail').val(job.trail);

                    // Show the edit modal
                    $('#editJobModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching job details:', error);
                    alert('Error fetching job details. Please try again later.');
                }
            });
        });


        // Edit job form submission handler
        $('#editJobForm').submit(function(event) {
            event.preventDefault();

            var formData = {
                job_id: $('#editJobId').val(),
                job_title: $('#editJobTitle').val(),
                job_description: $('#editJobDescription').val(),
                trail: $('#editTrail').val()
            };

            $.ajax({
                url: 'models/updateJob.php',
                type: 'PUT',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.statusCode === 200) {
                        alert(response.message);
                        $('#editJobModal').modal('hide');
                        fetchJobs(); // Refresh job table
                    } else {
                        alert('Failed to update job: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating job:', error);
                    alert('Error updating job. Please try again later.');
                }
            });
        });

        // Delete button click handler
        $(document).on('click', '.btn-delete', function() {
            var job_id = $(this).data('job_id');

            if (confirm('Are you sure you want to delete this job?')) {
                $.ajax({
                    url: 'models/deleteJob.php',
                    type: 'DELETE',
                    data: JSON.stringify({ job_id: job_id }),
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(response) {
                        if (response.statusCode === 200) {
                            alert(response.message);
                            fetchJobs(); // Refresh job table
                        } else {
                            alert('Failed to delete job: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting job:', error);
                        alert('Error deleting job. Please try again later.');
                    }
                });
            }
        });
    });
    </script>

<?php include 'footer.php'; ?>
