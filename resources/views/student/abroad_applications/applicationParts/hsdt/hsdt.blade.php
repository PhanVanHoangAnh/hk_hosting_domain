<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">13</span>
            </div>
            <div class="fw-semibold">
                Duyệt hồ sơ dự tuyển
                <div class="mt-1">
                    @php
                        $bgs = [
                            App\Models\AbroadApplication::STATUS_HSDT_NEW => 'primary text-white',
                            App\Models\AbroadApplication::STATUS_HSDT_WAIT_FOR_APPROVAL => 'secondary',
                            App\Models\AbroadApplication::STATUS_HSDT_APPROVED => 'success',
                            App\Models\AbroadApplication::STATUS_HSDT_REJECTED => 'danger text-white',
                        ];
                    @endphp

                    <span class="badge bg-{{ $bgs[$abroadApplication->hsdt_status] ?? 'info text-white' }}"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                        data-bs-placement="right">
                        {{ trans('messages.abroad.hsdt_status.' . $abroadApplication->hsdt_status) }}
                    </span>
                 
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9" form-data="complete-file-manager-container">
        <div class="row d-flex justify-content-around ">
            <div class="col-md-8 ">
                
            </div>
            
            @if($abroadApplication->isNewHSDT())
                <div class="col-md-4 d-none">
                    <div class="d-flex justify-content-end align-items-center mt-3 ">
                        <!--begin::Button-->
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'requestApprovalHSDT'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" row-action="request-approval">
                            <span class="material-symbols-rounded me-2">
                                add
                            </span>
                            Yêu cầu duyệt
                        </a>
                        <!--end::Button-->
                    </div>
                </div>
            @endif 
            @if($abroadApplication->isWaiForApprovalHSDT() && Auth::user()->hasPermission(App\Library\Permission::ABROAD_MANAGE_ALL))
                <div class="col-md-4 row">
                    <div class=" mt-3 col-6">
                        <!--begin::Button-->
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'approveHSDT'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px w-100" row-action="approve">
                        
                            Duyệt
                        </a>
                        <!--end::Button-->
                    </div>
                    
                    <div class="mt-3 col-6 ">
                        <!--begin::Button-->
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'rejectHSDT'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px w-100" row-action="reject">
                            
                            Không duyệt
                        </a>
                        <!--end::Button-->
                    </div>
                    
                </div>
            @endif 
            
            
        </div>
        <div class="row d-flex justify-content-around">
            {{-- Date input --}}
            
        </div>
    </div>
</div>

<script>
$(() => {
    
    RequestApproval.init();
    Approve.init();
    Reject.init();
});

var HSDTAction = function(actionMessage, action) {
    return {
        request: function(url) {
            ASTool.addPageLoadingEffect();

            $.ajax({
                url: url,
                method: 'POST',
                data: { _token: "{{ csrf_token() }}" }
            }).done((response) => {
                ASTool.alert({
                    message: response.message,
                    ok: function() {
                        hsdtManager.load();
                    }
                });
            }).fail(function(response) {
                ASTool.alert({
                    message: response.responseText,
                    ok: function() {
                        hsdtManager.load();
                    }
                });
            }).always(function() {
                ASTool.removePageLoadingEffect();
            });
        },

        init: function() {
            var container = document.querySelector('[form-data="complete-file-manager-container"]');
            var btnAction = container.querySelector('[row-action="' + action + '"]');
            var isCertificationDone = {{ $abroadApplication->isCheckStatusHSDT() ? 'true' : 'false' }};
            if (btnAction) {
                btnAction.addEventListener('click', e => {
                    e.preventDefault();
                    var url = btnAction.getAttribute('href');

                    if (!isCertificationDone) {
                        ASTool.alert({
                            icon: 'warning',
                            message: "Không thể yêu cầu duyệt vì chưa hoàn thành các bước trên.",
                            ok: function() {
                                // Do nothing or add any further action if needed
                            }
                        });
                    } else {
                        ASTool.confirm({
                            message: actionMessage,
                            ok: function() {
                                this.request(url);
                            }.bind(this)
                        });
                    }
                });
            }
        }
    };
};

var RequestApproval = HSDTAction('Bạn đã hoàn tất thông tin hồ sơ dự tuyển và yêu cầu duyệt?', 'request-approval');
var Approve = HSDTAction('Bạn có chắc chắn duyệt hồ sơ dự tuyển này chứ?', 'approve');
var Reject = HSDTAction('Bạn có chắc chắn từ chối duyệt hồ sơ dự tuyển này chứ?', 'reject');


</script>
