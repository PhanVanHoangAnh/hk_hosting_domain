@if ($noteLog->hasImage())
    @php
        $imageId = 'I_' . uniqid();
    @endphp
    <a id="{{ $imageId }}" href="{{ $noteLog->getUploadImage() }}" target="_blank">
        <img class="border p-0 rounded bg-white" src="{{ $noteLog->getUploadImage() }}?v={{ now()->timestamp }}" alt="" style="max-height:50;max-width:50px;">
    </a>

    <script>
        $(function() {
            $('#{{ $imageId }}').on('click', function(e) {
                e.preventDefault();

                // $('#{{ $imageId }}_Modal').modal('show');
                var popup = new Popup();
                popup.setContent(`
                                                                <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title">{{ $noteLog->content }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body p-2">
                                                                        <img class=""
                                                                            src="{{ $noteLog->getUploadImage() }}?v={{ now()->timestamp }}" alt=""
                                                                            width="100%">
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                `);

                popup.show();
            })
        });
    </script>
@else
    <img class="border p-1 rounded bg-white pe-none" style="opacity: 0.5" src="{{ $noteLog->getUploadImage() }}"
        alt="" height="50px">
@endif
