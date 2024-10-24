<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.main._head')

    @yield('head')
   
</head>
</head>
  <style>
    body {
      text-align: center;
      background: #EBF0F5;
    }
    h1 {
      color: #88B04B;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-weight: 900;
      font-size: 40px;
      margin-bottom: 10px;
    }
    p {
      color: #404F5E;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-size:20px;
      margin: 0;
    }
    i {
      color: #9ABC66;
      font-size: 100px;
      line-height: 200px;
      margin-left:-15px;
    }
    .card {
      background: white;
      padding: 60px;
      border-radius: 4px;
      box-shadow: 0 2px 3px #C8D0D8;
      display: inline-block;
      margin: 0 auto;
    }
  </style>
    
<body>
    
    <section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                <i class="checkmark">✓</i>
              </div>
                <h1>Thành công</h1> 
                <p>Chúng tôi đã nhận được yêu cầu của bạn
                    <br/> chúng tôi sẽ liên hệ với bạn sớm!</p>

                <a href="{{ action([App\Http\Controllers\Auth\RegisteredUserController::class, 'create']) }}"
                id="kt_modal_add_customer_cancel" class="btn btn-dark me-3 mt-10"
                style="border-radius: 20px;">Vào tài khoản của bạn</a>
             

                <a href="{{ action([App\Http\Controllers\Hk\SoftwareRequestController::class, 'requestForm']) }}" 
                  type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3 mt-10"
                  style="border-radius: 20px;">Quay trở lại</a>
              </div>
              <div>
                
                
              </div>
            </div>
           
        </div>
    </section>

    @include('layouts.main._footer')

    @yield('footer')
</body>

</html>