    </div>
    </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- DataTables & Buttons JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <!-- PDFMake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    
    <!-- JSZip for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#centersTable').DataTable({
                "pageLength": 20, // 20 rows per page
                "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
                "responsive": true,
                "dom": '<"row"<"col-md-6"B><"col-md-6"f>>rt<"row"<"col-md-6"l><"col-md-6"p>>',
                "buttons": [
                    {
                        extend: 'copy',
                        className: 'btn btn-secondary btn-sm',
                        text: '<i class="bi bi-files"></i> Copy'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm',
                        text: '<i class="bi bi-printer"></i> Print'
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-warning btn-sm',
                        text: '<i class="bi bi-eye"></i> Columns'
                    }
                ],
                "language": {
                    "search": "Search centers:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ centers",
                    "infoEmpty": "No centers available",
                    "infoFiltered": "(filtered from _MAX_ total centers)",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },
                "order": [[5, 'desc']], // Sort by Center Name by default
                "columnDefs": [
                    {
                        "targets": [5], // Action column
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "targets": [0, 1, 2, 3, 4], // Make other columns searchable
                        "searchable": true
                    }
                ],
                "initComplete": function() {
                    // Add custom search input styling
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                }
            });
            
            // Add custom styling to buttons
            $('.dt-buttons .btn').addClass('me-2 mb-2');
            
            // Add custom class to table for styling
            $('#centersTable').addClass('nowrap');
            
            // Toastr notification on table init
            
            // Handle responsive display
            $(window).on('resize', function() {
                table.columns.adjust().responsive.recalc();
            });
        });
        
        // History
        $(document).ready(function () {

            var table = $('#historyTable').DataTable({

                pageLength: 20,
                lengthMenu: [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"]
                ],

                scrollX: true,
                autoWidth: false,
                responsive: false,
                processing: true,

                dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row mt-3"<"col-md-6"l><"col-md-6"p>>',

                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-secondary btn-sm',
                        text: '<i class="bi bi-files"></i> Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        orientation: 'landscape',
                        pageSize: 'A3',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm',
                        text: '<i class="bi bi-printer"></i> Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-warning btn-sm',
                        text: '<i class="bi bi-eye"></i> Columns'
                    }
                ],

                language: {
                    search: "Search History:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No history available",
                    infoFiltered: "(filtered from _MAX_ total records)"
                },

                order: [[0, 'desc']],

                columnDefs: [
                    {
                        targets: '_all',
                        className: 'text-nowrap align-middle'
                    }
                ],

                initComplete: function () {

                    $('.dataTables_filter input')
                        .addClass('form-control form-control-sm');

                    $('.dataTables_length select')
                        .addClass('form-select form-select-sm');

                    $('.dt-buttons .btn').addClass('me-2 mb-2');

                    table.columns.adjust();
                }

            });

            $(window).on('resize', function () {
                table.columns.adjust();
            });

        });
        
        // Logout function
        function logoutExamCenter() {
            // Add your logout logic here
            window.location.href = base_url + 'logout';
        }

        // ==============Delete Account==================
        function deleteOnwerAccount(){

            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the owner account!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {

                if (result.isConfirmed) {

                    let form_url = base_url + "/delete-owner-account";

                    $.ajax({
                        url: form_url,
                        type: "POST",
                        dataType: "json",
                        contentType: "application/x-www-form-urlencoded",
                        processData: true,
                        success: function (response) {

                            if (response.status === "success") {
                                toastr.success(response.message);

                                setTimeout(function () {
                                    window.location.href = base_url + 'logout';
                                }, 2000);

                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            toastr.error("Something went wrong. Please try again.");
                        }
                    });

                }

            });

        }
    </script>
    <script>
        $(document).ready(function () {

            $("#notificationToggle").click(function (e) {
                e.stopPropagation();
                $("#notificationDropdown").toggle();
            });

            $(document).click(function () {
                $("#notificationDropdown").hide();
            });

        });
    </script>
</body>
</html>