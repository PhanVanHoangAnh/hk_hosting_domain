@php
    $boxId = 'F' . uniqid();
@endphp

<div id="{{ $boxId }}">
</div>

<script>
    $(function() {
        window.contactRelationshipBox = new ContactRelationshipBox({
            url: `{{ action('\App\Http\Controllers\RelationshipController@box', [
                'contact_id' => $contact->id,
                'to_contact_id' => $toContact->id,
            ]) }}`,
            box: $('#{{ $boxId }}'),
        });
    })

    var ContactRelationshipBox = class {
        constructor(options) {
            this.url = options.url;
            this.box = options.box;

            this.load();
        }

        load() {
            // find relationship
            $.ajax({
                url: this.url,
                type: 'GET',
            }).done((response) => {
                this.setContent(response);
            });
        }

        setContent(html, callback) {
            this.box.html(html);
            initJs(this.box[0]);

            if (typeof callback !== 'undefined') {
                callback();
            }
        }
    }
</script>