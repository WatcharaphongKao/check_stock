@section('title', 'HVF | Check Stock')
@extends('master.master')

@section('content')
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="" class="logo d-flex align-items-center w-auto">
                                    {{-- <img src="assets/img/yield2.png" alt=""> --}}
                                    <i class="bi bi-qr-code fs-1 mx-2"></i>
                                    <span class="d-none d-lg-block">Check Stock(FG)</span>
                                </a>
                            </div>
                            <!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate id="login_form">
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="username" class="form-control" id="yourUsername"
                                                    required>
                                                <div class="invalid-feedback">Please enter your username.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="passwordlogin"
                                                required>
                                            <div type="button" id="togglePassword3" onclick="togglePasswordLogin()">
                                                <i id="passwordIconLogin" class="fa fa-eye"></i>
                                            </div>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-success w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a
                                                    href="http://192.168.10.24:8888/it_work_notification/public/"
                                                    target="_blank"><span>Create
                                                        an account</span></a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="">HVF</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>
    <!-- End #main -->
    <script>
        function togglePasswordLogin() {
            var passwordInput = document.getElementById("passwordlogin");
            var passwordIcon = document.getElementById("passwordIconLogin");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        }
        //sweetalert error
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            // timer: 3000,
            showCloseButton: true, // เพิ่มปุ่มปิด
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        //login
        $('#login_form').on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '{{ url('/login') }}', // URL ที่จะทำการ POST
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status == 'success') {
                        Swal.fire({
                            title: 'Success',
                            html: data.message.replace(/\n/g, '<br>'),
                            icon: 'success',
                            backdrop: `
                        rgba(0,123,39,0.4)
                        url("https://media.tenor.com/ek214PnxJhEAAAAi/jagyasini-singh-cute-cat.gif")
                        left top
                        no-repeat
                    `
                        }).then(() => {
                            window.location.href = '{{ url('/form_scan') }}';
                        });
                    } else {
                        Toast.fire({
                            title: 'Error',
                            html: data.message,
                            icon: 'error',
                            backdrop: `
                       url("https://media.tenor.com/9z8aTaVmPfwAAAAi/cats-sad.gif")
                       right bottom
                       no-repeat
                    `
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 419) {
                        // Handle CSRF token expiration (Error 419)
                        Swal.fire({
                            title: 'Session Expired',
                            text: 'Your session has expired. Please refresh the page and try again.',
                            icon: 'warning',
                            confirmButtonText: 'Refresh Page',
                            backdrop: `
                        url("https://media.tenor.com/9z8aTaVmPfwAAAAi/cats-sad.gif")
                        right bottom
                        no-repeat
                    `
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        // Handle other errors
                        Toast.fire({
                            title: 'Error',
                            html: 'An error occurred. Please try again.',
                            icon: 'error',
                            backdrop: `
                        url("https://media.tenor.com/9z8aTaVmPfwAAAAi/cats-sad.gif")
                        right bottom
                        no-repeat
                    `
                        });
                    }
                }
            });
        });
    </script>

    {{-- middelwareLogin //app/http/middleware/usernameSession --}}
    @error('middelwareLogin')
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '{{ $message }}'
            });
        </script>
    @enderror
@endsection
