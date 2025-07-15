@section('title', 'Scan | HVF')
@extends('master.navbar')
@extends('master.master')

@section('content')

    <div class="container mt-3 ">
        <div class="row">
            <div class="cols-sm-12">
                <div class="form-control main text-bg-light">
                    <h2 class="text-center">HVF Check Stock</h2>

                    {{-- scan --}}
                    <div class="row g-0 mt-3 mb-3">
                        <div class="col-md-3">
                            <div class="p-3 mt-3 rounded card border-secondary" id="qrcode"></div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <div class="row">
                                    <div class=" row justify-content-start">
                                        <div class="col-sm-4">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control qr_pallet" id="qr_pallet"
                                                    placeholder="Pallet...">
                                                <label for="qr_pallet">Pallet</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="submit_pallet"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                        <div class="col-sm-2 mt-1">
                                            <button type="button" id="new_pallet" class="btn btn-outline-secondary">New
                                                Pallet</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control readonly" id="qr_box"
                                                placeholder="แสกน Box..." readonly>
                                            <label for="qr_box">Box No.</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-floating mb-3 ">
                                            <input type="date" class="form-control readonly" id="qr_date"
                                                name="qr_date" placeholder="แสกน Pallet..." readonly>
                                            <label for="qr_date">Date</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-floating mb-3 ">
                                            <input type="text" class="form-control qr_total readonly" id="qr_total"
                                                placeholder="จำนวนกล่องทั้งหมด..." readonly>
                                            <label for="qr_total">Total</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-floating mb-3 ">
                                            <input type="text" class="form-control qr_scan readonly" id="qr_scan"
                                                placeholder="แสกนไปแล้ว..."readonly>
                                            <label for="qr_scan">Total scan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End scan --}}

                    {{-- table --}}
                    <div class="col-sm-12 p-3">
                        <div class="table-responsive">
                            <table id="box_data" class="table mt-2 table-bordered">
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
    </div>

    <script>
        $(document).ready(function() {
            // ข้อความที่ต้องการให้เป็น QR Code
            var text = "http://192.168.10.24:8888/check_stock/public/";
            // สร้าง QR Code
            new QRCode(document.getElementById("qrcode"), text);
            var today = new Date().toISOString().split('T')[0];
            $('#qr_date').val(today);

            $('#qr_pallet').focus();
            $('#new_pallet').on('click', function() {
                location.reload();
            });

            var box_data = $('#box_data').DataTable({
                pageLength: 10,
                responsive: true,
                processing: true,
                cache: true,
                autoWidth: false,
                language: {
                    processing: '<div class="form-control"><i class="fa fa-spinner"></i> Processing...</div>'
                },
                dom: 'PBflrtip',
                columnDefs: [{
                    // "class": "text-center",
                    searchable: false,
                    orderable: false,
                    "targets": "_all"
                }],
                ajax: {
                    url: "{{ url('qr_pallet') }}",
                    type: "GET",
                    data: function(d) {
                        d.qr_pallet = $('#qr_pallet').val();
                    }
                },
                order: [
                    [2, 'asc'],
                ],

                columns: [{
                        title: '#',
                        data: 'DT_RowIndex',
                        width: '5%'
                    },
                    {
                        className: "text-start",
                        data: 'checked',
                        title: 'Checked',
                        name: 'checked',
                        width: '5%',
                        render: function(data, type, row) {
                            return `<input class="form-check-input" type="checkbox" ${data == 1 ? 'checked' : ''} disabled>`;
                        }
                    },
                    {
                        data: 'box_no',
                        title: 'Box No.',
                        name: 'box_no',
                        width: '15%'
                    },
                    {
                        data: 'pallet',
                        title: 'Pallet No.',
                        name: 'pallet',
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
                        width: '15%'
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
                        width: '5%'
                    },

                ],
            });
            // $('#qr_pallet').on('keypress', function(event) {
            //     if (event.key === 'Enter') {
            //         box_data.ajax.reload();
            //         $('#qr_pallet').prop('readonly', true).addClass('readonly');
            //         $('#qr_box').prop('readonly', false).removeClass('readonly');
            //         var qr_pallet = $('#qr_pallet').val();
            //         loadQrBinData(qr_pallet);


            //         $('#qr_box').focus();
            //     }
            // });
            function handleQrPalletSubmission() {
                var qr_pallet = $('#qr_pallet').val();
                if (qr_pallet.trim() !== '') { // ตรวจสอบว่าค่าไม่ว่างเปล่า
                    box_data.ajax.reload();
                    $('#qr_pallet').prop('readonly', true).addClass('readonly');
                    $('#qr_box').prop('readonly', false).removeClass('readonly');
                    loadQrBinData(qr_pallet);
                    $('#qr_box').focus();
                }
            }

            // กด Enter
            $('#qr_pallet').on('keydown', function(event) {
                if (event.key === 'Enter' || event.key === 'Tab') {
                    event.preventDefault(); // ใช้เมื่อไม่ต้องการให้ Tab เลื่อนโฟกัส
                    handleQrPalletSubmission();
                }
            });

            // กดปุ่ม Submit
            $('#submit_pallet').on('click', function() {
                handleQrPalletSubmission();
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
            $('#qr_box').on('keydown', function(event) {
                var qr_box = $('#qr_box').val();
                var qr_pallet = $('#qr_pallet').val();
                if (event.key === 'Enter' || event.key === 'Tab') {
                    event.preventDefault(); // ใช้เมื่อไม่ต้องการให้ Tab เลื่อนโฟกัส
                    $.ajax({
                        url: '{{ url('/checked') }}',
                        type: 'POST',
                        data: {
                            qr_box: qr_box,
                            qr_pallet: qr_pallet,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                box_data.ajax.reload();
                                loadQrBinData(qr_pallet);
                                $('#qr_box').val('');
                                $('#qr_box').focus();

                            } else {
                                Toast.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    backdrop: `
                                   url("https://media.tenor.com/9z8aTaVmPfwAAAAi/cats-sad.gif")
                                   right bottom
                                   no-repeat
                            `

                                });
                                $('#qr_box').val('');
                                $('#qr_box').focus();


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
                            $('#qr_box').focus();

                        }
                    });

                    // box_data.ajax.reload();
                    $('#qr_box').focus();
                }
            });

            function loadQrBinData(qr_pallet) {
                $.ajax({
                    // url: "{{ url('/box_pallet') }}/" + encodeURIComponent(qr_pallet),
                    url: "{{ url('/box_pallet') }}/" + qr_pallet,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const data = response[0];
                        fillFormFields(data); // อัปเดตข้อมูลในฟอร์ม
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while fetching data.',
                            icon: 'error'
                        });
                    }
                });
            }

            function fillFormFields(data) {
                // alert(data.pallet)
                // $('.qr_pallet').val(data.pallet);
                $('.qr_total').val(data.qr_total);
                $('.qr_scan').val(data.qr_scan);
            }
        });
    </script>

@endsection
