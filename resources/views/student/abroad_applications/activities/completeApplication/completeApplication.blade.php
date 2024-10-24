
<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">7</span>
            </div>
            <div class="fw-semibold">
                Hoàn thành hồ sơ
                <div class="mt-1">
                    @php
                        $bgs = [
                            App\Models\AbroadApplication::STATUS_NEW => 'primary text-white',
                            App\Models\AbroadApplication::STATUS_WAIT_FOR_APPROVAL => 'secondary',
                            App\Models\AbroadApplication::STATUS_APPROVED => 'success',
                            App\Models\AbroadApplication::STATUS_REJECTED => 'danger text-white',
                        ];
                    @endphp
    
                    <span class="badge bg-{{ $bgs[$abroadApplication->status] ?? 'info text-white' }}"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                        data-bs-placement="right">
                        {{ trans('messages.abroad.hsdt_status.' . $abroadApplication->status) }}
                    </span>
    
                 
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="col-md-9" form-data="complete-manager-container">
        <div class="row d-flex justify-content-around ">
            <div class="col-md-8 ">
                
            </div>
            
            @if($abroadApplication->isNewCompleteApplication())
                <div class="col-md-4 d-none">
                    <div class="d-flex justify-content-end align-items-center mt-3 ">
                        <!--begin::Button-->
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'requestApprovalCompleteApplication'],
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
            @if($abroadApplication->isWaiForApprovalCompleteApplication() && Auth::user()->hasPermission(App\Library\Permission::ABROAD_MANAGE_ALL))
                    <div class="col-md-4 row">
                        <div class=" mt-3 col-6">
                            <!--begin::Button-->
                            <a href="{{ action(
                                [App\Http\Controllers\Student\AbroadController::class, 'approveCompleteApplication'],
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
                                [App\Http\Controllers\Student\AbroadController::class, 'rejectCompleteApplication'],
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

var CompleteApplicationAction = function(actionMessage, action) {
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
                        completeApplication.load();
                    }
                });
            }).fail(function(response) {
                ASTool.alert({
                    message: response.responseText,
                    ok: function() {
                        completeApplication.load();
                    }
                });
            }).always(function() {
                ASTool.removePageLoadingEffect();
            });
        },

        init: function() {
            var container = document.querySelector('[form-data="complete-manager-container"]');
            var btnAction = container.querySelector('[row-action="' + action + '"]');
            var isCertificationDone = {{ $abroadApplication->isCheckStatus() ? 'true' : 'false' }};
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

var RequestApproval = CompleteApplicationAction('Bạn đã hoàn tất thông tin hồ sơ và yêu cầu duyệt?', 'request-approval');
var Approve = CompleteApplicationAction('Bạn có chắc chắn duyệt hồ sơ này chứ?', 'approve');
var Reject = CompleteApplicationAction('Bạn có chắc chắn từ chối duyệt hồ sơ này chứ?', 'reject');


</script>
