@extends('layouts.main.popup', [
    
])

@section('title')
   Link thanh toán OnePay trả góp cho {{ $order->contacts->name }}
@endsection


@php
    $controlId = uniqid();
@endphp

@section('content')

   
        <div class="card card-bordered m-3">
            <div class="card-body position-relative">
                <!--begin::Row-->
                <div class="d-flex align-items-center flex-wrap">
                    <!--begin::Input-->
                    <div id="kt_clipboard_4" class="me-5">{{$redirectUrl}}</div>
                    
                    <!--end::Input-->
        
                    <!--begin::Button-->
                    <button class="btn btn-icon btn-sm btn-light position-absolute end-0 top-0 m-2" data-clipboard-target="#kt_clipboard_4">
                        <i class="ki-duotone ki-copy fs-2 text-muted"></i>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Row-->
            </div>
        </div>  

    <script>
       // Select elements
      
            const target = document.getElementById('kt_clipboard_4');
            const button = target.nextElementSibling;

           
            clipboard = new ClipboardJS(button, {
                target: target,
                text: function () {
                    return target.innerHTML;
                }
            });

            // Success action handler
            clipboard.on('success', function (e) {

                navigator.clipboard.writeText(target.innerHTML);

                var checkIcon = button.querySelector('.ki-check');
                var copyIcon = button.querySelector('.ki-copy');

                // Exit check icon when already showing
                if (checkIcon) {
                    return;
                }

                // Create check icon
                checkIcon = document.createElement('i');
                checkIcon.classList.add('ki-duotone');
                checkIcon.classList.add('ki-check');
                checkIcon.classList.add('fs-2x');

                // Append check icon
                button.appendChild(checkIcon);

                // Highlight target
                // const classes = ['text-success', 'fw-boldest'];
                // target.classList.add(...classes);

                // Highlight button
                button.classList.add('btn-success');

                // Hide copy icon
                copyIcon.classList.add('d-none');

                // Revert button label after 3 seconds
                setTimeout(function () {
                    // Remove check icon
                    copyIcon.classList.remove('d-none');

                    // Revert icon
                    button.removeChild(checkIcon);

                    // Remove target highlight
                    // target.classList.remove(...classes);

                    // Remove button highlight
                    button.classList.remove('btn-success');
                }, 3000)
            });
       
    </script>
@endsection
