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
                        <div class="col-md-2">
                            <label for="Bin">Bin:</label>
                            <select class="form-select" aria-label="Default select example" name="group_bin" id="group_bin"
                                data-role="group_bin">
                            </select>
                        </div>
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
                            <select class="form-select primary" aria-label="Default select example" name="data" id="data">
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
                                        <div class="form-group">
                                            <input type="file" name="file" id="file" class="form-control"
                                                accept=".xlsx, .xls, .csv" required>
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

            var onhand = $('#onhand').DataTable({
                pageLength: 10,
                responsive: true,
                processing: true,
                serverSide: true,
                cache: false,
                autoWidth: true,
                language: {
                    processing: '<div class="form-control"><i class="fa fa-spinner"></i> Processing...</div>'
                },
                dom: 'PBflrtip',
                columnDefs: [{
                    // "class": "text-center",
                    // searchable: false,
                    orderable: false,
                    "targets": "_all"
                }],
                ajax: {
                    url: "{{ url('qr_import') }}",
                    type: "GET",
                    data: function(d) {
                        d.group_bin = $('#group_bin').val();
                        d.checked = $('#checked').val();
                        d.month = $('#month').val();
                        d.year = $('#year').val();
                        d.data = $('#data').val();
                    }
                },
                order: [
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
                        width: '10%'
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
                        width: '20%'
                    },
                    {
                        data: 'lot',
                        title: 'Lot',
                        name: 'lot',
                        width: '10%'
                    },
                    {
                        data: 'description',
                        title: 'description',
                        name: 'description',
                        width: '20%'
                    },
                    {
                        data: 'bin',
                        title: 'Bin.',
                        name: 'bin',
                        width: '5%'
                    },
                    {
                        data: 'qty',
                        title: 'Qty/Box',
                        name: 'qty',
                        width: '5%'
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
                $('#checked').val('-- Checked --').trigger('change'); // Reset year filter
                $('#group_bin').val('-- Bin --').trigger('change'); // Reset year filter
                $('#data').val('current').trigger('change'); // Reset year filter
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
                        // แสดง Swal loading ก่อนเริ่ม AJAX
                        Swal.fire({
                            title: 'Uploading...',
                            text: 'Please wait while your file is being uploaded.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading(); // เปิด animation ของการโหลด
                            }
                        });
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
                            `
                        });
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
                        // แสดง Swal loading ก่อนเริ่ม AJAX
                        Swal.fire({
                            title: 'Moving data...',
                            text: 'Please wait Moving data.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading(); // เปิด animation ของการโหลด
                            }
                        });
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
                    }
                });
            });


        });
    </script>
@endsection
