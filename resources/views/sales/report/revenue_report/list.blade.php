@if (!empty($weeksInRange))
    <div class="card-body pt-0 mt-5">
        <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">

            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="border  ps-5" rowspan="3">Mã NV sales</th>
                        <th class="border min-w-200px ps-5" rowspan="3">Tên sales</th>
                        <th class="border ps-5" rowspan="3">Mã khách hàng</th>
                        <th class="border min-w-200px w-auto ps-5" rowspan="3">Tên khách hàng</th>
                        {{-- <th class="border min-w-200px ps-5" rowspan="3">Tuần dự thu</th> --}}
                        <th class="border min-w-200px ps-5" rowspan="3">Tên dịch vụ</th>

                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th colspan="3" class="text-center border">Dự thu</th>
                        <th colspan="5" class="text-center border">Thực thu</th>
                        <th class="border min-w-200px w-auto ps-5" rowspan="3">Note lí do</th>
                    </tr>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="border ps-5 min-w-200px w-auto fw-bold ">Số tiền</th>
                        <th class="border ps-5 min-w-150px w-auto fw-bold ">Ngày dự thu</th>
                        <th class="border ps-5 min-w-150px w-auto fw-bold ">Trạng thái dự thu</th>
                        <th class="border ps-5 min-w-100px w-auto fw-bold ">Nằm trong dự thu</th>
                        <th class="border ps-5 min-w-150px w-auto fw-bold ">Hợp đồng</th>
                        <th class="border ps-5 min-w-100px w-auto fw-bold ">Nằm ngoài dự thu</th>
                        <th class="border ps-5 min-w-200px w-auto fw-bold ">Tổng thực thu</th>
                        <th class="border ps-5 min-w-200px w-auto fw-bold ">Ngày thu thực tế</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>

                    {{-- @foreach ($weeksInRange as $week) --}}
                        @foreach ($accountGroups as $accountGroup)
                            <tr class="border fw-bold bg-light-warning text-gray-800">
                                <td colspan="14" class="ps-5 text-center">
                                    {{ $accountGroup->name }}
                                </td>
                            </tr>
                            @foreach ($accountGroup->accounts as $account)
                                <tr class="border ">
                                    <td class="ps-5">{{ $account->code }}</td>
                                    <td class="ps-5">{{ $account->name }} </td>
                                    <td class="ps-5  text-gray-800">

                                    </td>
                                    <td class="ps-5">

                                    </td>
                                    {{-- <td class="ps-5">
                                        W
                                        W{{ $week['week_number'] }}
                                    </td> --}}
                                    <td class="ps-5"></td>
                                    <td class="ps-5">
                                    </td>
                                    <td class="ps-5"></td>
                                    <td class="ps-5"></td>
                                    <td class="ps-5"></td>
                                    <td class="ps-5"></td>
                                    <td class="ps-5"></td>
                                    <td class="ps-5"></td>
                                    <td class="ps-5"></td>
                                </tr>

                                @foreach ($account->getAccountKpiNoteContacts() as $contactId)
                                    <tr class="border">
                                        <td class="ps-5"></td>
                                        <td class="ps-5"></td>
                                        <td class="ps-5">{{ App\Models\Contact::find($contactId)->code }}</td>
                                        <td class="ps-5">
                                            {{ App\Models\Contact::find($contactId)->name }}
                                        </td>
                                        {{-- <td class="ps-5">ád</td> --}}
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <li>
                                                    {{ trans('messages.service_type.' . $accountKpiNote->service_type) }}
                                                    @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                        (Môn: {{ $accountKpiNote->subject ? $accountKpiNote->subject->name : '--' }})
                                                    @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                        (Loại: {{ $accountKpiNote->extracurricular_type }})
                                                    @endif
                                                </li>
                                            @endforeach
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <li>
                                                    {{ number_format($accountKpiNote->amount) }}₫
                                                </li>
                                            @endforeach
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <li>
                                                    {{ \Carbon\Carbon::parse($accountKpiNote->estimated_payment_date)->format('d/m/Y') }}
                                                </li>
                                            @endforeach
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                
                                                    @php
                                                        $orders = App\Models\Contact::find($contactId)->orders()->byAccountKpiNote($accountKpiNote)->get();
                                                        $actualRevenue = 0;
                                                    @endphp

                                                    @if ($orders->isEmpty())
                                                        <li>Chưa có hợp đồng</li>
                                                    @else
                                                        @foreach($orders as $order)
                                                            @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                                @foreach($order->orderItems as $orderItem)
                                                                    @php
                                                                        $eduPrice = $orderItem->calculateEduPriceKPINote($order, $accountKpiNote);
                                                                        $actualRevenue += $eduPrice;
                                                                    @endphp
                                                                @endforeach
                                                            @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                                @php
                                                                    $actualRevenue += $order->sumAmountPaid();
                                                                @endphp
                                                            @endif
                                                        @endforeach

                                                        @php
                                                            
                                                            if ($accountKpiNote->status == 'fail') {
                                                                $status = 'Fail';
                                                            }elseif ($actualRevenue > $accountKpiNote->amount) {
                                                                $status = 'Vượt dự thu';
                                                            } elseif ($actualRevenue == $accountKpiNote->amount) {
                                                                $status = 'Đã thu đủ';
                                                            } elseif ($actualRevenue > 0 && $actualRevenue < $accountKpiNote->amount) {
                                                                $status = 'Chưa thu đủ';
                                                            } else {
                                                                $status = 'Chưa thu';
                                                            }
                                                        @endphp

                                                        <li> 
                                                             {{ $status }}
                                                        </li>
                                                    @endif
                                                
                                            @endforeach
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <div class="text-semibold">
                                                    {{ trans('messages.service_type.' . $accountKpiNote->service_type) }}
                                                    @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                        (Môn: {{ $accountKpiNote->subject ? $accountKpiNote->subject->name : '--' }})
                                                    @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                        (Loại: {{ $accountKpiNote->extracurricular_type }})
                                                    @endif
                                                </div>

                                                @php
                                                    $orders = App\Models\Contact::find($contactId)->orders()->byAccountKpiNote($accountKpiNote)->get();
                                                @endphp

                                                @if ($orders->isEmpty())
                                                    <li>Chưa có hợp đồng</li>
                                                @else
                                                    @foreach($orders as $order)
                                                    {{-- <li>
                                                        {{ $order->sumAmountPaid() > $accountKpiNote->amount ?  App\Helpers\Functions::formatNumber($accountKpiNote->amount)  .'₫' :   App\Helpers\Functions::formatNumber($order->sumAmountPaid()).'₫' }}
                                                    </li> --}}
                                                    @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                        @foreach($order->orderItems as $orderItem) 
                                                            @php
                                                                $eduPrice = $orderItem->calculateEduPriceKPINote($order, $accountKpiNote);
                                                            @endphp
                                                            @if ($eduPrice)
                                                                <li>
                                                                    {{ $eduPrice > $accountKpiNote->amount ?  App\Helpers\Functions::formatNumber($accountKpiNote->amount)  .'₫' :   App\Helpers\Functions::formatNumber($eduPrice).'₫' }}
                                                                    {{-- {{ App\Helpers\Functions::formatNumber($eduPrice) }}₫  
                                                                    {{ $eduPrice > $accountKpiNote->amount ? App\Helpers\Functions::formatNumber($eduPrice - $accountKpiNote->amount) . '₫' : '0₫' }} --}}
                                                                </li> 
                                                            @endif  
                                                        @endforeach
                                                        @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                            <li>
                                                                {{ $order->sumAmountPaid() > $accountKpiNote->amount ?  App\Helpers\Functions::formatNumber($accountKpiNote->amount)  .'₫' :   App\Helpers\Functions::formatNumber($order->sumAmountPaid()).'₫' }}
                                                            </li>
                                                        @endif
                                                    
                                                    @endforeach
                                                @endif
 
                                            @endforeach
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <div class="text-semibold">
                                                    {{ trans('messages.service_type.' . $accountKpiNote->service_type) }}
                                                    @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                        (Môn: {{ $accountKpiNote->subject ? $accountKpiNote->subject->name : '--' }})
                                                    @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                        (Loại: {{ $accountKpiNote->extracurricular_type }})
                                                    @endif
                                                </div>
                                                @php
                                                    $orders = App\Models\Contact::find($contactId)->orders()->byAccountKpiNote($accountKpiNote)->get();
                                                @endphp

                                                @if ($orders->isEmpty())
                                                    <li>Chưa có hợp đồng</li>   
                                                @else
                                                    @foreach($orders as $order)
                                                    <li> {{ $order->code }} </li>
                                                    @endforeach
                                                @endif
 
                                            @endforeach
                                            
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <div class="text-semibold">
                                                    {{ trans('messages.service_type.' . $accountKpiNote->service_type) }}
                                                    @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                        (Môn: {{ $accountKpiNote->subject ? $accountKpiNote->subject->name : '--' }})
                                                    @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                        (Loại: {{ $accountKpiNote->extracurricular_type }})
                                                    @endif
                                                </div>
                                                @php
                                                    $orders = App\Models\Contact::find($contactId)->orders()->byAccountKpiNote($accountKpiNote)->get();
                                                @endphp

                                                @if ($orders->isEmpty())
                                                    <li>Chưa có hợp đồng</li>
                                                @else
                                                    @foreach($orders as $order)
                                                        @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                            @foreach($order->orderItems as $orderItem) 
                                                                @php
                                                                $eduPrice = $orderItem->calculateEduPriceKPINote($order, $accountKpiNote);
                                                            @endphp
                                                            @if ($eduPrice)
                                                                <li>
                                                                    {{-- {{ App\Helpers\Functions::formatNumber($eduPrice) }}₫   --}}
                                                                    {{ $eduPrice > $accountKpiNote->amount ? App\Helpers\Functions::formatNumber($eduPrice - $accountKpiNote->amount) . '₫' : '0₫' }}
                                                                </li> 
                                                            @endif  
                                                            @endforeach
                                                        @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                            <li>{{ $order->sumAmountPaid() > $accountKpiNote->amount ?  App\Helpers\Functions::formatNumber($order->sumAmountPaid() - $accountKpiNote->amount) .'₫'  : 0 .'₫' }} </li>
                                                        @endif
                                                        
                                                    @endforeach
                                                @endif

                                            @endforeach
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <div class="text-semibold">
                                                    {{ trans('messages.service_type.' . $accountKpiNote->service_type) }}
                                                    @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                        (Môn: {{ $accountKpiNote->subject ? $accountKpiNote->subject->name : '--' }})
                                                    @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                        (Loại: {{ $accountKpiNote->extracurricular_type }})
                                                    @endif
                                                </div>
                                                @php
                                                    $orders = App\Models\Contact::find($contactId)->orders()->byAccountKpiNote($accountKpiNote)->get();
                                                @endphp

                                                @if ($orders->isEmpty()) 
                                                    <li>Chưa có hợp đồng</li>
                                                @else
                                                    @foreach($orders as $order)
                                                        @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                            @foreach($order->orderItems as $orderItem) 
                                                                @php
                                                                    $eduPrice = $orderItem->calculateEduPriceKPINote($order, $accountKpiNote);
                                                                @endphp
                                                                @if ($eduPrice)
                                                                    <li>{{ App\Helpers\Functions::formatNumber($eduPrice )}}₫      </li> 
                                                                @endif
                                                               
                                                            @endforeach
                                                        @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                            <li> {{ App\Helpers\Functions::formatNumber($order->sumAmountPaid()) }}₫   </li>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            @endforeach
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                                <div class="text-semibold">
                                                    {{ trans('messages.service_type.' . $accountKpiNote->service_type) }}
                                                    @if ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EDU'))
                                                        (Môn: {{ $accountKpiNote->subject ? $accountKpiNote->subject->name : '--' }})
                                                    @elseif ($accountKpiNote->service_type == config('constants.SERVICE_TYPE_EXTRACURRICULAR'))
                                                        (Loại: {{ $accountKpiNote->extracurricular_type }})
                                                    @endif
                                                </div>
                                                @php
                                                    $orders = App\Models\Contact::find($contactId)->orders()->byAccountKpiNote($accountKpiNote)->get();
                                                    
                                                @endphp
                                                    
                                                @if ($orders->isEmpty())  
                                                    <li>Chưa có hợp đồng</li>
                                                @else
                                                    @foreach($orders as $order)
                                                    <li>{{ !is_null($order->getLastPaymentDate()) ? date('d/m/Y', strtotime($order->getLastPaymentDate()->payment_date))  : "Chưa thu" }}</li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            
                                        </td>
                                        <td class="ps-5 text-nowrap">
                                            @foreach (App\Models\Contact::find($contactId)->accountKpiNotes->where('account_id', $account->id) as $accountKpiNote)
                                            <li>
                                                {{ $accountKpiNote->note }}
                                            </li>
                                        @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    {{-- @endforeach --}}


                </tbody>

            </table>
        </div>
        <div class="mt-5">
            {{-- {{ $accountGroups->links() }} --}}
        </div>
    </div>
@else
    <p class="fs-4 text-center mb-5 text-danger mt-10">
        Vui lòng chọn ngày bắt đầu và kết thúc
    </p>
@endif
