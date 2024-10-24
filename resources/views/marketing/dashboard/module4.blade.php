<div id="DashboardModule4" class="h-xl-100">
    <div class="card card-flush h-xl-100" style="display: flex;
align-items: center;
justify-content: center;">

        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

    </div>

</div>



<script>
    $(() => {
        $.ajax({
            url: '{{ action([App\Http\Controllers\Marketing\DashboardController::class, 'module4']) }}'
        }).done(function (response) {
            $('#DashboardModule4').html(response);
        });
    })
</script>