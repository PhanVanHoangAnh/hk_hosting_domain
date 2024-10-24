<div id="DashboardModule3" class="h-xl-100">
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
            url: '{{ action([App\Http\Controllers\Marketing\DashboardController::class, 'module3']) }}'
        }).done(function (response) {
            $('#DashboardModule3').html(response);
        });
    })
</script>