@extends('layout')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đăng ký tài khoản</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Trang Chủ</a></li>
            <li class="breadcrumb-item active text-white">Đăng ký</li>
        </ol>
    </div>
    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-6 col-xl-6 ">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>Bạn đã có tài khoản?</h2>
                            <p>Hãy đăng nhập vào hệ thống để khám phá cửa hàng</p>
                            <a href="{{route('loginCustomer')}}" class="btn btn-primary">Đăng nhập</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <h3>Xin chào bạn ! <br>
                        Đăng ký tài khoản ngay bây giờ</h3>
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-block">
                            {{session()->get('success')}}
                            @php session()->forget('success') @endphp
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-danger alert-block">
                            {{session()->get('error')}}
                            @php session()->forget('error') @endphp
                        </div>
                    @endif
                    <form action="{{route('addCustomer')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label for="customer_name" class="form-label my-3">Họ tên <sup>*</sup></label>
                                    <input type="text" id="customer_name" name="customer_name"
                                           class="form-control" placeholder="Họ và tên"
                                           value="{{old('customer_name')}}">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label for="customer_name" class="form-label my-3">Email <sup>*</sup></label>
                                    <input type="email" id="customer_email" name="customer_email"
                                           class="form-control" placeholder="Nhập tài khoản email"
                                           value="{{old('email_account')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-item">
                            <label for="customer_name" class="form-label my-3">Mật khẩu <sup>*</sup></label>
                            <input type="password" id="password_account" name="password_account" class="form-control"
                                   placeholder="Nhập mật khẩu" value="{{old('password_account')}}">
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label for="customer_name" class="form-label my-3">Ngày sinh <sup>*</sup></label>
                                    <input type="date" id="customer_birthday" name="customer_birthday"
                                           class="form-control" placeholder="Ngày sinh"
                                           value="{{old('customer_birthday')}}">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label for="customer_name" class="form-label my-3">Số điện thoại
                                        <sup>*</sup></label>
                                    <input type="text" id="customer_phone" name="customer_phone"
                                           class="form-control" placeholder="Số điện thoại"
                                           value="{{old('customer_phone')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="customer_name" class="form-label my-3">Avatar</label>
                            <input type="file" id="customer_avatar" name="customer_avatar" class="form-control"
                                   placeholder="Nhập mật khẩu" value="{{old('password_account')}}">
                        </div>
                        <div class="form-item">
                            <label for="customer_name" class="form-label my-3">Địa chỉ <sup>*</sup></label>
                            <input type="text" id="customer_address" name="customer_address"
                                   class="form-control" placeholder="Địa chỉ" value="{{old('customer_address')}}">
                        </div>
                        <div class="form-item">
                            <button type="submit" id="btnSubmit"
                                    class="btn border-warning text-uppercase text-primary my-3">Đăng ký
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">

        $("#btnSubmit").click(function () {
            var customer_name = $("#customer_name").val();
            var customer_email = $("#customer_email").val();
            var password_account = $("#password_account").val();
            var customer_birthday = $("#customer_birthday").val();
            var customer_phone = $("#customer_phone").val();
            var customer_address = $("#customer_address").val();
            if (customer_name == '') {
                toastr["error"]("Không được để trống họ và tên?");
                return false;
            } else if (customer_email == '') {
                toastr["error"]("Không được để trống địa chỉ email?");
                return false;
            } else if (password_account == '') {
                toastr["error"]("Không được để trống mật khẩu?");
                return false;
            } else if (customer_birthday == '') {
                toastr["error"]("Không được để trống ngày sinh?");
                return false;
            } else if (customer_phone == '') {
                toastr["error"]("Không được để trống số điện thoại?");
                return false;
            } else if (customer_address == '') {
                toastr["error"]("Không được để trống địa chỉ?");
                return false;
            }
            return true;

        });
    </script>

@endsection
