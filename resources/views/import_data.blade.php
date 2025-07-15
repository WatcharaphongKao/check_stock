@section('title', 'Import Data & OnHand | HVF')
@extends('master.navbar')
@extends('master.master')

@section('content')
    <div class="container-fluid mt-3 ">
        <div class="row-cols-sm-12 ">

            <div class="form-control text-bg-light main">
                <h2 class="text-center">Import Data & OnHand</h2>

                <div class="col-md-12 p-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="month">Month:</label>
                            <select class="form-select" name="month" id="month">
                                <option selected disabled>Select a month</option>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}">
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="year">Year:</label>
                            <select class="form-select" name="year" id="year">
                                <option selected disabled>Select a year</option>
                                @php
                                    $currentYear = date('Y');
                                    $endYear = $currentYear - 2; // Adjust the range as needed
                                @endphp
                                @for ($year = $currentYear; $year >= $endYear; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        {{-- <div class="col-md-2">
                            <label for="Bin">Bin:</label>
                            <select class="form-select" aria-label="Default select example" name="group_bin" id="group_bin"
                                data-role="group_bin">
                            </select>
                        </div> --}}
                        {{-- <div class="col-md-2">
                            <label for="Grade">Grade:</label>
                            <select class="form-select" aria-label="Default select example" name="grade" id="grade"
                                data-role="grade">
                                <option disabled selected>-- Grade --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div> --}}
                        <div class="col-md-2">
                            <label for="Checked">Checked:</label>
                            <select class="form-select" aria-label="Default select example" name="checked" id="checked">
                                <option disabled selected>-- Checked --</option>
                                <option value="0">Check</option>
                                <option value="1">Checked</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="data">Data:</label>
                            <select class="form-select primary" aria-label="Default select example" name="data"
                                id="data">
                                <option value="current" selected>Current</option>
                                <option value="past">Past</option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <br>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-primary" id="filterBtn">Filter</button>
                                <button class="btn btn-secondary" id="clearFilterBtn">Clear Filters</button>
                                <button class="btn btn-success" id="importButton" data-bs-toggle="modal"
                                    data-bs-target="#Import_Modal">Import Data</button>
                                <button class="btn btn-info" id="transfer_past">Transfer Data</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="Import_Modal" tabindex="-1" aria-labelledby="Import_ModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="Import_ModalLabel">Import Data</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="importForm" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="month">Month:</label>
                                                <select class="form-select" name="month_import" id="month_import">
                                                    <option selected disabled>Select a month</option>
                                                    @foreach (range(1, 12) as $month)
                                                        <option value="{{ $month }}">
                                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="year">Year:</label>
                                                <select class="form-select" name="year_import" id="year_import">
                                                    <option selected disabled>Select a year</option>
                                                    @php
                                                        $currentYear = date('Y');
                                                        $endYear = $currentYear - 2; // Adjust the range as needed
                                                    @endphp
                                                    @for ($year = $currentYear; $year >= $endYear; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-2 form-group">
                                                <input type="file" name="file" id="file" class="form-control"
                                                    accept=".xlsx, .xls, .csv" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- table --}}

                <div class="col-sm-12 p-3">
                    <div class="table-responsive">
                        <table id="onhand" class="table mt-2 table-bordered">
                            <thead class="table-info">
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- End table --}}
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            var buttonTypes = ['excel', 'print', 'copy'];
            var onhand = $('#onhand').DataTable({
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, 1000],
                    [10, 25, 50, 100, 1000]
                ],
                scrollX: true,
                scrollY: '400px',
                select: true,
                autoFill: true,
                colReorder: true,
                responsive: true,
                processing: true,
                // serverSide: true,
                cache: false,
                autoWidth: true,
                language: {
                    processing: '<div class="form-control"><i class="fa fa-spinner"></i> Processing...</div>'
                },
                searchPanes: {
                    columns: [1, 2, 8, 3, 5], // กำหนดคอลัมน์ที่จะแสดงใน searchPanes
                    initCollapsed: true
                },
                dom: 'PBflrtip',
                buttons: buttonTypes.map(function(type) {
                    return {
                        extend: type,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column ===
                                        10
                                    ) { // Assuming the 'Checked' column is the 11th column
                                        return data.includes('checked') ? '1' :
                                        '0'; // ดึงค่าจาก data โดยตรง
                                    }
                                    return data;
                                }
                            }
                        }
                    };
                }).concat([{
                    extend: 'colvis',
                }, ]),
                columnDefs: [{
                        // "class": "text-center",
                        // searchable: false,
                        orderable: false,
                        "targets": "_all"
                    },
                    {
                        targets: [11, 12, 13], // Example: Hide columns 2 and 4 initially (index 1, 3)
                        visible: false // Set these columns to be hidden by default
                    },
                ],
                ajax: {
                    url: "{{ url('qr_import') }}",
                    type: "GET",
                    data: function(d) {
                        d.group_bin = $('#group_bin').val();
                        d.checked = $('#checked').val();
                        d.month = $('#month').val();
                        d.year = $('#year').val();
                        d.data = $('#data').val();
                        d.grade = $('#grade').val();
                    }
                },
                order: [
                    [1, 'desc'],
                    [4, 'asc'],
                ],

                columns: [{
                        title: '#',
                        data: 'DT_RowIndex',
                        width: '5%',
                        searchable: false,
                    },
                    {
                        data: 'month_stock',
                        title: 'Month.',
                        name: 'month_stock',
                        width: '5%'
                    },
                    {
                        data: 'year_stock',
                        title: 'Year.',
                        name: 'year_stock',
                        width: '5%'
                    },
                    {
                        data: 'pallet',
                        title: 'Pallet No.',
                        name: 'pallet',
                        width: '15%'
                    },
                    {
                        data: 'box_no',
                        title: 'Box No.',
                        name: 'box_no',
                        width: '15%'
                    },
                    {
                        data: 'part',
                        title: 'Part',
                        name: 'part',
                        width: '15%'
                    },
                    {
                        data: 'lot',
                        title: 'Lot',
                        name: 'lot',
                        width: '10%',
                        class: "text-start",
                    },
                    {
                        data: 'description',
                        title: 'description',
                        name: 'description',
                        width: '20%'
                    },
                    {
                        data: 'grade',
                        title: 'Grade.',
                        name: 'grade',
                        width: '5%'
                    },
                    {
                        data: 'qty',
                        title: 'Qty/Box',
                        name: 'qty',
                        width: '10%'
                    },
                    {
                        className: "text-end",
                        data: 'checked',
                        title: 'Checked',
                        name: 'checked',
                        width: '5%',
                        render: function(data, type, row) {
                            return `<input class="form-check-input" type="checkbox" ${data == 1 ? 'checked' : ''} disabled>`;
                        }
                    },
                    {
                        data: 'created_at',
                        title: 'Created At',
                        name: 'created_at',
                    },
                    {
                        data: 'date_checked',
                        title: 'Date Checked',
                        name: 'date_checked',
                    },
                    {
                        data: 'updated_by',
                        title: 'Updated By',
                        name: 'updated_by',
                    },
                ],
            });



            // Filter data when the "Filter" button is clicked
            $('#filterBtn').on('click', function() {
                // alert('test')
                onhand.ajax.reload();
            });

            $('#clearFilterBtn').on('click', function() {
                $('#month').val('Select a month').trigger('change'); // Reset month filter
                $('#year').val('Select a year').trigger('change'); // Reset year filter
                $('#month_import').val('Select a month').trigger('change'); // Reset month filter
                $('#year_import').val('Select a year').trigger('change'); // Reset year filter
                $('#checked').val('-- Checked --').trigger('change'); // Reset year filter
                $('#group_bin').val('-- Bin --').trigger('change'); // Reset year filter
                $('#data').val('current').trigger('change'); // Reset year filter
                $('#grade').val('-- Grade --').trigger('change'); // Reset year filter
                onhand.ajax.reload();
            });

            //sweetalert error
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                showCloseButton: true, // เพิ่มปุ่มปิด
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            let swalInstance; // ตัวแปรสำหรับเก็บ Swal
            var progressInterval;
            $('#importForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: "{{ url('/import/data') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    serverSide: true,
                    beforeSend: function() {
                        swalInstance = Swal.fire({

                            title: 'Importing...',
                            html: `
                         <div style="text-align: center;">
                             <!-- Spinner -->
                             <div class="spinner-border" role="status" style="margin-bottom: 10px; color: #4caf50;">
                                 <span class="visually-hidden">Loading...</span>
                             </div>
                             <!-- Progress Bar -->
                             <div style="width: 100%; background-color: #f3f3f3; border-radius: 5px;">
                                 <div id="progress-bar" style="width: 0%; height: 20px; background-color: #4caf50; border-radius: 5px;"></div>
                             </div>
                             <p id="progress-text" style="margin-top: 10px;">0% completed</p>
                             <p id="text" style="margin-top: 10px;">Please wait while your file is being uploaded.</p>
                         </div>
                         `,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        progressInterval = setInterval(() => {
                            checkProgress('import');
                        }, 500);
                    },

                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            html: response.message.replace(/\n/g,
                                '<br>'
                            ), // Replace \n with <br> for line breaks
                            icon: 'success',
                            backdrop: `
                                        rgba(0,123,39,0.4)
                                        url("https://media.tenor.com/ek214PnxJhEAAAAi/jagyasini-singh-cute-cat.gif")
                                        left top
                                        no-repeat
                                        `
                        });
                        onhand.ajax.reload();
                        clearInterval(progressInterval)
                        $('#Import_Modal').modal('hide');
                    },
                    error: function(xhr) {
                        var errorMessage =
                            'An error occurred while inserting the record.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON
                                .errors).join('<br>');
                        }
                        Toast.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error',
                            backdrop: `
                                   url("https://media.tenor.com/9z8aTaVmPfwAAAAi/cats-sad.gif")
                                   right bottom
                                   no-repeat
                            `,
                            confirmButtonText: 'Reload'
                        });
                        clearInterval(progressInterval)

                    }
                });
            });

            // Bind change event to both selects
            $('#month, #year').change(toggleButtonVisibility);
            $('#Import_Modal').on('hidden.bs.modal', function(e) {
                // เคลียร์ค่าทุกครั้งเมื่อโมดัลถูกปิดลง
                console.log('Modal is hidden');
                $('#Import_Modal input[type="text"]').val('');
                $('#Import_Modal input[type="number"]').val('');
                $('#Import_Modal input[type="file"]').val('');
                $('#Import_Modal textarea').val('');
                $('#Import_Modal select').prop('selectedIndex', 0);
                $('#Import_Modal input[name="id"]').val('');
                $('#Import_Modal select').val(null).trigger('change');
            });

            $('#transfer_past').hide();

            function toggleButtonVisibility() {
                // Check if both selects have a value
                if ($('#month').val() && $('#year').val()) {
                    $('#transfer_past').show();
                } else {
                    $('#transfer_past').hide();
                }
            }

            // Bind change event to both selects
            $('#month, #year').change(toggleButtonVisibility);
            // Onclick event for the button
            $('#transfer_past').click(function() {
                // Get selected values
                const selectedMonth = $('#month').val();
                const selectedYear = $('#year').val();
                const selectedData = $('#data').val();

                // AJAX request
                $.ajax({
                    url: "{{ url('/transfer_past/data') }}",
                    method: 'POST', // Use the appropriate method (POST, GET, etc.)
                    data: {
                        month: selectedMonth,
                        year: selectedYear,
                        Selectdata: selectedData,
                        _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                    },
                    beforeSend: function() {
                        // Show Swal loading with progress bar
                        swalInstance = Swal.fire({
                            title: 'Moving data...',
                            html: `
                    <div style="width: 100%; background-color: #f3f3f3; border-radius: 5px;">
                        <div id="progress-bar" style="width: 0%; height: 20px; background-color: #4caf50; border-radius: 5px;"></div>
                    </div>
                    <p id="progress-text">0% completed</p>
                    `,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        progressInterval = setInterval(() => {
                            checkProgress('transfer');
                        }, 500);
                    },
                    success: function(response) {
                        if (response.success === false) {
                            // หาก success = false ให้แสดง error
                            Swal.fire({
                                title: 'Error',
                                html: response.message.replace(/\n/g,
                                    '<br>'), // แสดงข้อความที่ได้จาก response
                                icon: 'error',
                                backdrop: `
                                    url("https://media.tenor.com/9z8aTaVmPfwAAAAi/cats-sad.gif")
                                    right bottom
                                    no-repeat
                                `
                            });
                        } else {
                            Swal.fire({
                                title: 'Success',
                                html: response.message.replace(/\n/g,
                                    '<br>'
                                ), // Replace \n with <br> for line breaks
                                icon: 'success',
                                backdrop: `
                                        rgba(0,123,39,0.4)
                                        url("https://media.tenor.com/ek214PnxJhEAAAAi/jagyasini-singh-cute-cat.gif")
                                        left top
                                        no-repeat
                                        `
                            });
                            onhand.ajax.reload();
                        }
                        clearInterval(progressInterval)
                    },
                    error: function(xhr) {
                        var errorMessage =
                            'An error occurred while inserting the record.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON
                                .errors).join('<br>');
                        }
                        Toast.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error',
                            backdrop: `
                                   url("https://media.tenor.com/9z8aTaVmPfwAAAAi/cats-sad.gif")
                                   right bottom
                                   no-repeat
                            `
                        });
                        clearInterval(progressInterval)

                    }
                });
            });

            // checkProgress
            function checkProgress(data) {
                // console.log(data)
                $.ajax({
                    url: "{{ url('/get-import-progress') }}",
                    method: "GET",
                    data: {
                        data: data,
                        _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                    },
                    success: function(progress) {
                        // console.log(progress);
                        const percent = Math.round((progress.processed / progress.total) * 100);

                        $('#progress-bar').css('width', percent + '%');
                        $('#progress-text').text(`${percent}% completed`);
                    },
                    error: function() {
                        console.log("Error fetching progress data");
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to fetch progress data.',
                            icon: 'error'
                        })
                    }

                });
            }

        });
    </script>
@endsection
