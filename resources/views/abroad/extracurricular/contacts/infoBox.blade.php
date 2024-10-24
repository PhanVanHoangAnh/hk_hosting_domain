<div class="border border-gray-400 bg-light p-5 mt-8">
    {{-- <label class="mb-3" style="border-radius:0;">{{ $contact->name }}</label> --}}

    <div class="row">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <span>Họ tên</span>
                <div class="ms-auto fw-semibold"> {{ $contact->name }}</div>
            </div>
            <div class="separator my-3"></div>
            <div class="d-flex align-items-center">
                <span>Ngày sinh</span>
                <div class="ms-auto fw-semibold">  {{ $contact->age ? \Carbon\Carbon::parse($contact->age)->format('d/m/Y') : '--' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <span>Email</span>
                <div class="ms-auto fw-semibold"> {{ $contact->email ?? '--' }}</div>
            </div>
            <div class="separator my-3"></div>
            <div class="d-flex align-items-center">
                <span>CCCD/Passport</span>
                <div class="ms-auto fw-semibold"> {{ $contact->identity_id }}</div>
            </div>
        </div>
    </div>
    <div class="separator my-3"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <span>Địa chỉ</span>
                <div class="ms-auto fw-semibold"> {{ $contact->getFullAddress() }}</div>
            </div>
        </div>
    </div>
</div>