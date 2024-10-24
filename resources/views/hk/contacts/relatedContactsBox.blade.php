@if($contacts->count())
    <div data-control="related-contact-list" class="border mt-3 p-3 border-gray-400 bg-light mb-7">
        <label class="pb-2 fw-semibold">Liên hệ trùng lặp</label>
        <table class="table table-bordered bg-white">
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td class="fw-semibold">{{ $contact->name }}</td>
                        <td class="{{ App\Helpers\Functions::campareEmails(request()->email, $contact->email) ? 'bg-light-warning' : '' }}">
                            <span class="d-flex align-items-center">
                                <span class="material-symbols-rounded me-2 small">
                                    email
                                </span>
                                <span>{{ $contact->email }}</span>
                            </span>
                        </td>
                        <td class="{{ App\Helpers\Functions::camparePhones(request()->phone, $contact->phone) ? 'bg-light-warning' : '' }}">
                            <span class="d-flex align-items-center">
                                <span class="material-symbols-rounded me-2 small">
                                    call
                                </span>
                                <span>{{ $contact->phone }}</span>
                            </span>
                        </td>
                        <td>
                            <div class="text-end">
                                <a related-control="edit-contact"
                                    href="{{ action(
                                        [App\Http\Controllers\Hk\ContactController::class, 'edit'],
                                        [
                                            'id' => $contact->id,
                                        ],
                                    ) }}" class="d-inline-block">
                                    <span class="d-flex align-items-center">
                                        <span class="material-symbols-rounded me-1 small">
                                            edit
                                        </span>
                                        <span>Chỉnh sửa</span>
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(function() {
            //
            new HandleUpdateContact({
                button: $('[related-control="edit-contact"]'),
            });
        });

        var HandleUpdateContact = class {
            constructor(options) {
                this.button = options.button;

                //
                this.events();
            }

            events() {
                this.button.on('click', (e) => {
                    e.preventDefault();

                    var url = this.button.attr('href');

                    // hide create popup
                    CreateContactPopup.getPopup().hide();

                    // show popup
                    UpdateContactPopup.load(url);
                });
            }
        }
    </script>
@endif