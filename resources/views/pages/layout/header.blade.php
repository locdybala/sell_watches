<header>
    @php
        $customer_id = Session::get('customer_id');
        $shipping_id = Session::get('shipping_id');
    @endphp
    <!-- Header Start -->
    <div class="header-area">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="menu-wrapper">
                    <!-- Logo -->
                    <div class="logo">
                        <a  href="{{URL::to('/')}}"><img style="width: 200px; height: 30px;" src="{{asset('frontend/assets/img/logo/logo1.png')}}" alt=""></a>
                    </div>
                    <!-- Main-menu -->
                    <div class="main-menu d-none d-lg-block">
                        <nav>
                            <ul id="navigation">
                                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                                <li class="hot"><a href="{{route('shop')}}">Danh mục</a>
                                    <ul class="submenu">
                                        @foreach ($category as $category)
                                            <li>
                                                <a href="{{ route('detailCategory',['id'=>$category->category_id]) }}"> {{$category->category_name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="#">Thương hiệu</a>
                                    <ul class="submenu">
                                        @foreach ($brand as $brand)
                                            <li>
                                                <a href="{{ route('detailBrand',['id'=>$brand->brand_id]) }}">{{$brand->brand_name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li><a href="{{route('categoryPostIndex')}}">Tin tức</a>
                                </li>
                                <li><a href="{{route('contact')}}">Liên hệ</a></li>
                                @if ($customer_id != NULL && $shipping_id == NULL)

                                    <li>
                                        <a href="{{URL::to('/checkout')}}"> Thanh toán</a>
                                    </li>

                                @elseif($customer_id != NULL && $shipping_id != NULL)

                                    <li><a href="{{URL::to('/payment')}}"> Thanh toán</a>
                                    </li>
                                @else
                                    <li><a href="{{URL::to('/login-checkout')}}"> Thanh toán</a>
                                    </li>
                                @endif
                                @if ($customer_id != NULL)
                                    <li><a href="#">Tài khoản</a>
                                        <ul class="submenu">
                                            <li><a href="{{route('history')}}">Lịch sử mua hàng</a></li>
                                            <li><a href="{{route('edit_customer',['id'=>Session::get('customer_id')])}}">Thông tin cá nhân</a></li>
                                            <li><a href="{{route('logout_checkout')}}">Đăng xuất</a></li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <!-- Header Right -->
                    <div class="header-right">
                        <ul>
                            <li>
                                <div class="nav-search search-switch">
                                    <span class="flaticon-search"></span>
                                </div>
                            </li>
                            <li><a href="{{route('cart')}}"><span class="flaticon-shopping-cart"></span></a></li>
                            @if ($customer_id != NULL)
                                <li><a href="{{route('list_wistList', ['customerId' => $customer_id])}}"><span class="flaticon-heart"></span></a></li>

                                <li>
                                    <a href="">
                                        <span class="flaticon-user"> {{Session::get('customer_name')}}</span>
                                    </a>
                                </li>
                            @else
                                <li><a href="{{URL::to('/login-checkout')}}"><span class="flaticon-user"> Đăng nhập</span></a></li>

                            @endif
                        </ul>
                    </div>
                </div>
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>



