<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/5676/5676330.png" type="image/x-icon">

    {{-- bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    {{-- icon bootstarp --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- font --}}
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">


    {{-- jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- qrcode --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    {{-- data table --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.bootstrap5.css">

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> ใส่แล้ว clear layout ไม่หมด --}}
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.bootstrap5.js"></script>

    {{-- data table button export --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.bootstrap5.css">

    <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.colVis.min.js"></script>

    {{-- data table select --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/select/2.1.0/css/select.bootstrap5.css">

    <script src="https://cdn.datatables.net/select/2.1.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.1.0/js/select.bootstrap5.js"></script>

    {{-- data table  autofill --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.7.0/css/autoFill.bootstrap5.css">

    <script src="https://cdn.datatables.net/autofill/2.7.0/js/dataTables.autoFill.js"></script>
    <script src="https://cdn.datatables.net/autofill/2.7.0/js/autoFill.bootstrap5.js"></script>

    {{-- data table colReorder --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.0.4/css/colReorder.bootstrap5.css">

    <script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.js"></script>
    <script src="https://cdn.datatables.net/colreorder/2.0.4/js/colReorder.bootstrap5.js"></script>

    {{-- data table searchPanes --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.3.3/css/searchPanes.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/3.0.0/css/select.bootstrap5.css">

    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/dataTables.searchPanes.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/searchPanes.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/select.bootstrap5.js"></script>

    {{-- sweetalert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main CSS File -->
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">





    <style>
        body {
            background-color: hsl(144.17deg 19.6% 85.49%);
            font-family: "Kanit" !important;
        }

        .main {
            margin-top: 100px;
        }

        #qrcode {
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 15px;
            padding-left: 10px;
            padding-right: 15px;
            padding-bottom: 15px;
            width: 70%;
        }

        .readonly {
            background-color: #f0f0f0 !important;
            color: #000000 !important;
            border: 1px solid #dcdcdc !important;
            cursor: not-allowed !important;
        }

        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link.show {
            color: rgb(59 203 102);
        }
    </style>
</head>

<body>
    @yield('content')

    @yield('footer')

</body>

</html>

<script>
    $(document).ready(function() {

        // select Bin
        $.ajax({
            url: '{{ url('group_bin') }}',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // ตรวจสอบข้อมูลที่ได้รับ
                // console.log('Raw data:', data);

                var select = $('[data-role="group_bin"]');
                select.empty();
                select.append(
                    '<option class="text-start" selected disabled>-- Bin --</option>');

                // ใช้ข้อมูลจากอาร์เรย์ภายในอาร์เรย์
                var group_bin = data.group_bin || []; // ดึงข้อมูลจากคีย์ที่ถูกต้อง

                $.each(group_bin, function(index, item) {
                    var group_binValue = item.bin.trim();
                    select.append('<option value="' + group_binValue + '">' +
                        group_binValue + '</option>');
                });
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });
</script>
    <script type="text/javascript">
        var timeout;
        var timeoutDuration = 900000;// 900,000 มิลลิวินาที = 15 นาที
        // var timeoutDuration = 5000;// 900,000 มิลลิวินาที = 15 นาที

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                // แสดง SweetAlert แจ้งเตือน
                Swal.fire({
                    icon: 'error',
                    title: 'Timeout',
                    text: 'กรุณาล็อคอินใหม่',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false, // ห้ามกดนอก popup แล้วปิด
                    allowEscapeKey: false, // ห้ามกด ESC เพื่อปิด
                }).then((result) => {
                    // เมื่อกด OK จะรีไดเรกไปที่หน้า logout
                    if (result.isConfirmed) {
                        window.location.href = "{{ url('/logout') }}"; // ไปที่หน้า login
                    }
                });
            }, timeoutDuration);
        }

        // เรียกใช้เมื่อผู้ใช้เคลื่อนไหว
        // เรียกใช้เมื่อผู้ใช้เคลื่อนไหวครั้งแรก
        window.onload = resetTimer;
        document.onmousemove = function() {
            resetTimer(); // เรียกใช้การตั้งเวลาใหม่เมื่อเคลื่อนไหว
            // console.log('test')
        };
        document.onkeypress = function() {
            resetTimer(); // เรียกใช้การตั้งเวลาใหม่เมื่อกดปุ่ม
            // console.log('test')
        };
    </script>
