@extends('home')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div>
            <div class="register-req">
                <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
            </div>
            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="table-responsive cart_info">
                            <form action="{{route('update_cart')}}" method="POST">
                                @csrf
                                <table class="table table-condensed">
                                    <thead>
                                    <tr class="cart_menu">
                                        <td class="image">Hình ảnh</td>
                                        <td class="description">Tên sản phẩm</td>
                                        <td class="price">Giá sản phẩm</td>
                                        <td class="quantity">Số lượng</td>
                                        <td class="total">Thành tiền</td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(Session::get('cart')==true)
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach(Session::get('cart') as $key => $cart)
                                            @php
                                                $subtotal = $cart['product_price']*$cart['product_qty'];
                                                $total+=$subtotal;
                                            @endphp

                                            <tr>
                                                <td class="cart_product">
                                                    <img src="{{asset('upload/product/'.$cart['product_image'])}}"
                                                         width="90" alt="{{$cart['product_name']}}"/>
                                                </td>
                                                <td class="cart_description">
                                                    <h4><a href=""></a></h4>
                                                    <p>{{$cart['product_name']}}</p>
                                                </td>
                                                <td class="cart_price">
                                                    <p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
                                                </td>
                                                <td class="cart_quantity">
                                                    <div class="cart_quantity_button">
                                                        <input class="cart_quantity" type="number" min="1"
                                                               name="cart_qty[{{$cart['session_id']}}]"
                                                               value="{{$cart['product_qty']}}">
                                                    </div>
                                                </td>
                                                <td class="cart_total">
                                                    <p class="cart_total_price">
                                                        {{number_format($subtotal,0,',','.')}}đ
                                                    </p>
                                                </td>
                                                <td class="cart_delete">
                                                    <a class="cart_quantity_delete"
                                                       href="{{route('delete_product_cart',['session_id'=>$cart['session_id']])}}"><i
                                                            class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty"
                                                       class="check_out btn btn-default btn-sm"></td>
                                            <td><a class="btn btn-default check_out"
                                                   href="{{route('delete_all_cart')}}">Xóa giỏ
                                                    hàng</a></td>
                                            <td>
                                                @if(Session::get('coupon'))
                                                    <a class="btn btn-default check_out"
                                                       href="{{route('delete_coupon')}}">Xóa mã khuyến mãi</a>
                                                @endif
                                            </td>
                                            <td colspan="2">
                                                <li>Tổng tiền :<span>{{number_format($total,0,',','.')}}đ</span></li>
                                                @if(Session::get('coupon'))
                                                    <li>

                                                        @foreach(Session::get('coupon') as $key => $cou)
                                                            @if($cou['coupon_condition']==1)
                                                                Mã giảm : {{$cou['coupon_number']}} %
                                                                <p>
                                                                    @php
                                                                        $total_coupon = ($total*$cou['coupon_number'])/100;

                                                                    @endphp
                                                                </p>
                                                                <p>
                                                                    @php
                                                                        $total_after_coupon = $total-$total_coupon;
                                                                    @endphp
                                                                </p>
                                                            @elseif($cou['coupon_condition']==2)
                                                                Mã giảm
                                                                : {{number_format($cou['coupon_number'],0,',','.')}} k
                                                                <p>
                                                                    @php
                                                                        $total_coupon = $total - $cou['coupon_number'];

                                                                    @endphp
                                                                </p>
                                                                @php
                                                                    $total_after_coupon = $total_coupon;
                                                                @endphp
                                                            @endif
                                                        @endforeach


                                                    </li>
                                                @endif

                                                @if(Session::get('fee'))
                                                    <li>


                                                        Phí vận chuyển <span>{{number_format(Session::get('fee'),0,',','.')}}đ</span>
                                                        <a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i
                                                                class="fa fa-times"></i></a>

                                                    </li>
                                                        <?php $total_after_fee = $total + Session::get('fee'); ?>
                                                @endif

                                                <li>Tổng còn:
                                                    @php
                                                        if(Session::get('fee') && !Session::get('coupon')){
                                                            $total_after = $total_after_fee;
                                                            echo number_format($total_after,0,',','.').'đ';
                                                        }elseif(!Session::get('fee') && Session::get('coupon')){
                                                            $total_after = $total_after_coupon;
                                                            echo number_format($total_after,0,',','.').'đ';
                                                        }elseif(Session::get('fee') && Session::get('coupon')){
                                                            $total_after = $total_after_coupon;
                                                            $total_after = $total_after + Session::get('fee');
                                                            echo number_format($total_after,0,',','.').'đ';
                                                        }elseif(!Session::get('fee') && !Session::get('coupon')){
                                                            $total_after = $total;
                                                            echo number_format($total_after,0,',','.').'đ';
                                                        }

                                                    @endphp
                                                    <input type="hidden" name="total_after" class="total_after" value="{{$total_after}}">
                                                </li>

                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="5">
                                                <center>
                                                    @php
                                                        echo 'Làm ơn thêm sản phẩm vào giỏ hàng';
                                                    @endphp
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </form>
                            <div class="row">
                                <div class="col-md-4">
                                    @if(Session::get('cart'))

                                        <form method="POST" action="{{route('check_coupon')}}">
                                            @csrf
                                            <ul class="user_info">
                                                <li class="single_field"></li>
                                                <li></li>
                                                <li class="single_field zip-field">
                                                    <label>Mã giảm giá</label>
                                                    <input style="width: 400px !important;" type="text" class="form-control" name="coupon"
                                                           placeholder="Nhập mã giảm giá">
                                                </li>
                                            </ul>
                                            <input style="margin-top: -5px; margin-bottom: 15px;" type="submit"
                                                   class="btn btn-default update"
                                                   name="check_coupon" value="Tính mã giảm giá">
                                        </form>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <form>
                                        @csrf
                                        <ul class="user_info">
                                            <li class="single_field">
                                                <label for="exampleInputPassword1">Chọn thành phố</label>
                                                <select name="city" id="city"
                                                        class="form-control input-sm m-bot15 choose city">

                                                    <option value="">--Chọn tỉnh thành phố--</option>
                                                    @foreach($city as $key => $ci)
                                                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                            <li class="single_field">
                                                <label for="exampleInputPassword1">Chọn quận huyện</label>
                                                <select name="province" id="province"
                                                        class="form-control input-sm m-bot15 province choose">
                                                    <option value="">--Chọn quận huyện--</option>

                                                </select>
                                            </li>
                                            <li class="single_field zip-field">
                                                <label for="exampleInputPassword1">Chọn xã phường</label>
                                                <select name="wards" id="wards"
                                                        class="form-control input-sm m-bot15 wards">
                                                    <option value="">--Chọn xã phường--</option>
                                                </select>
                                            </li>
                                        </ul>
                                        <input style="margin-top: -5px; margin-bottom: 20px;" type="button"
                                               value="Tính phí vận chuyển" name="calculate_order"
                                               class="btn btn-default update calculate_delivery">
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section id="do_action">
        <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="bill-to">
                            <p>Điền thông tin gửi hàng</p>
                            <div class="form-one">
                                <form method="POST">
                                    @csrf
                                    <input type="text" name="shipping_email"
                                           value="{{$customer->customer_email}}" class="shipping_email"
                                           placeholder="Điền email">
                                    <input type="text" name="shipping_name" value="{{$customer->customer_name}}"
                                           class="shipping_name" placeholder="Họ và tên người gửi">
                                    <input type="text" name="shipping_address"
                                           value="{{$customer->customer_address}}" class="shipping_address"
                                           placeholder="Địa chỉ gửi hàng">
                                    <input type="text" name="shipping_phone"
                                           value="{{$customer->customer_phone}}" class="shipping_phone"
                                           placeholder="Số điện thoại">
                                    <textarea name="shipping_notes" class="shipping_notes"
                                              placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>

                                    @if(Session::get('fee'))
                                        <input type="hidden" name="order_fee" class="order_fee"
                                               value="{{Session::get('fee')}}">
                                    @else
                                        <input type="hidden" name="order_fee" class="order_fee" value="30000">
                                    @endif

                                    @if(Session::get('coupon'))
                                        @foreach(Session::get('coupon') as $key => $cou)
                                            <input type="hidden" name="order_coupon" class="order_coupon"
                                                   value="{{$cou['coupon_code']}}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="order_coupon" class="order_coupon"
                                               value="no">
                                    @endif


                                    <div class="">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                                            <select name="payment_select"
                                                    class="form-control input-sm m-bot15 payment_select">
                                                <option value="1">Tiền mặt</option>
                                                <option value="2">Qua chuyển khoản</option>

                                            </select>
                                        </div>
                                    </div>
                                    <input type="button" value="Xác nhận đơn hàng" name="send_order"
                                           class="btn btn-primary btn-sm send_order">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script>
        $(document).ready(function () {
            $('.choose').on('change', function () {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';
                // alert(action);
                //  alert(matp);
                //   alert(_token);

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{url('/select-delivery')}}',
                    method: 'POST',
                    data: {action: action, ma_id: ma_id, _token: _token},
                    success: function (data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.calculate_delivery').click(function(){
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if(matp == '' && maqh =='' && xaid ==''){
                    alert('Làm ơn chọn để tính phí vận chuyển');
                }else{
                    $.ajax({
                        url : '{{url('/calculate-fee')}}',
                        method: 'POST',
                        data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
                        success:function(){
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function(){
            $('.send_order').click(function(){
                swal({
                    title: "Xác nhận đơn hàng",
                    text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                    icon: "warning",
                    cancel: "Đóng,chưa mua",
                    buttons: ["Đóng,chưa mua", "Cảm ơn, Mua hàng"] ,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            debugger;
                            var shipping_email = $('.shipping_email').val();
                            var shipping_name = $('.shipping_name').val();
                            var shipping_address = $('.shipping_address').val();
                            var shipping_phone = $('.shipping_phone').val();
                            var shipping_notes = $('.shipping_notes').val();
                            var shipping_method = $('.payment_select').val();
                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();
                            var _token = $('input[name="_token"]').val();
                            var total_after = $('.total_after').val();

                            $.ajax({
                                url: '{{url('/confirm-order')}}',
                                method: 'POST',
                                data:{shipping_email:shipping_email,total_after:total_after,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_notes:shipping_notes,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method},
                                success:function(data){
                                    swal("Đơn hàng", "Đơn hàng của bạn đã được gửi thành công", "success");
                                    if (data) {
                                        window.location.replace(data);
                                    }
                                }
                            });

                            // window.setTimeout(function(){
                            //     location.reload();
                            // } ,3000);
                        }
                        else {
                            swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");

                        }
                    });


            });
        });

    </script>

@endsection