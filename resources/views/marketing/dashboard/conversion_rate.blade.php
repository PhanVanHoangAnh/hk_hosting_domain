<link rel="stylesheet" href="{{ url('chart_circle/circle.css') }}" />





<script src="{{ url('chart_circle/js/mk_charts.js') }}"></script>

<div id="DashboardModuleCRate" class="row g-5 g-xl-6 mb-5 mb-xl-6" >
    <div class="col" style="height: 260px">
        <div class="card card-flush h-xl-100" style="display: flex;
    align-items: center;
    justify-content: center;">
    
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
    
        </div>
    </div>
    <div class="col" style="height: 260px">
        <div class="card card-flush h-xl-100" style="display: flex;
    align-items: center;
    justify-content: center;">
    
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
    
        </div>
    </div>
    <div class="col" style="height: 260px">
        <div class="card card-flush h-xl-100" style="display: flex;
    align-items: center;
    justify-content: center;">
    
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
    
        </div>
    </div>
    <div class="col" style="height: 260px">
        <div class="card card-flush h-xl-100" style="display: flex;
    align-items: center;
    justify-content: center;">
    
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
    
        </div>
    </div>
    <div class="col" style="height: 260px">
        <div class="card card-flush h-xl-100" style="display: flex;
    align-items: center;
    justify-content: center;">
    
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
    
        </div>
    </div>

</div>



<script>
    $(() => {
        $.ajax({
            url: '{{ action([App\Http\Controllers\Marketing\DashboardController::class, 'conversionRate']) }}'
        }).done(function (response) {
            $('#DashboardModuleCRate').html(response);
        });
    })
</script>