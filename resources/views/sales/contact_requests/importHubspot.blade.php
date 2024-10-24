@extends('layouts.main.popup')
@section('title')
    Đồng bộ dữ liệu từ Hubspot
@endsection
@section('content')
    <form class="form">
        @csrf

        <!--begin::Modal body-->
        <div class="modal-body">
            <!--begin::Input group-->
            <div class="form-group">
                <!--begin::Dropzone-->
                <div class="dropzone dropzone-queue">
                    <label class="form-label ">HubSpot Token</label>
                    <input class="form-control" value="{{ env('HUBSPOT_API_TOKEN', '') }}" placeholder="Nhập API token từ tài khoản Hubspot của ASMS"
                        name="api-token"id="api-token-input" />
                    <!--begin::Error message-->
                    <p class="text-danger d-none" id="tokenError">Nhập sai token. Vui lòng kiểm tra lại.</p>
                    <!--end::Error message-->
                    <div>
                        <button class="btn btn-primary mt-3" id="btnTokenHubSpot">Kết nối & xem trước dữ liệu</button>
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Dropzone-->

            </div>
            <!--end::Input group-->
        </div>
        <!--end::Modal body-->
    </form>

    <script>
        $(() => {
            TokenHubSpotPopup.init();
        })

        var TokenHubSpotPopup = function() {
            var popupTokenHubSpot;
            var btnTokenHubSpot;
            var tokenValue;
            var tokenInput;
            var handleTokenHubSpot = function() {
                btnTokenHubSpot.addEventListener('click', (e) => {
                    e.preventDefault();

                    tokenValue = document.querySelector('input[name="api-token"]').value;
                    popupTokenHubSpot.setData({
                        token: tokenValue
                    });
                    // Simulate token validation
                    if (tokenValue === "") {
                        tokenInput.classList.add('is-invalid');
                        tokenError.classList.remove('d-none');
                        tokenError.style.display = "block";
                        return; // Don't proceed if token is empty
                    } else {
                        tokenInput.classList.remove('is-invalid');
                        tokenError.style.display = "none";
                    }
                    HubSpotPopup.getPopup().hide();
                    popupTokenHubSpot.load();
                })
            }
            return {
                init: function() {
                    popupTokenHubSpot = new Popup({
                        url: "{{ action('\App\Http\Controllers\HubSpotController@preview') }}",
                    });
                    btnTokenHubSpot = document.getElementById('btnTokenHubSpot');
                    tokenInput = document.getElementById('api-token-input');
                    tokenError = document.getElementById('tokenError');
                    handleTokenHubSpot();

                },
                getPopup: function() {
                    return popupTokenHubSpot;
                }

            }
        }();
    </script>
@endsection
