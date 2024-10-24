<div id="DashboardModule1" class="h-lg-100">
    <div id="" class="card card-flush h-lg-100" style="display: flex;
align-items: center;
height: 300px!important;
justify-content: center;">

        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

    </div>

</div>



<script>
    $(() => {
        $.ajax({
            url: '{{ action([App\Http\Controllers\Marketing\DashboardController::class, 'module1']) }}'
        }).done(function (response) {
            $('#DashboardModule1').html(response);
        });
    })
</script>