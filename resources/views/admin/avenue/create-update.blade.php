@extends('admin.layout.app')
@section('title', $title)

@section('content')
@include('admin.partials.flash')
@include('admin.avenue.breadcrumb')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
    </div>
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div class="card-body row">
            <div class="col-md-6 form-group">
                <label>Name</label>
                <input name="name" class="form-control" value="{{ old('name', $avenue->name) }}" required>
            </div>
            <div class="col-md-6 form-group">
                <label>Place</label>
                <input name="place" class="form-control" value="{{ old('place', $avenue->place) }}" required>
            </div>
            <div class="col-md-12 form-group">
                <label>Address</label>
                <input name="address" class="form-control" value="{{ old('address', $avenue->address) }}">
            </div>
            <div class="col-md-3 form-group">
                <label>City</label>
                <input name="city" class="form-control" value="{{ old('city', $avenue->city) }}">
            </div>
            <div class="col-md-3 form-group">
                <label>State</label>
                <input name="state" class="form-control" value="{{ old('state', $avenue->state) }}">
            </div>
            <div class="col-md-3 form-group">
                <label>Country</label>
                <input name="country" class="form-control" value="{{ old('country', $avenue->country) }}">
            </div>
            <div class="col-md-3 form-group">
                <label>Postal Code</label>
                <input name="postal_code" class="form-control" value="{{ old('postal_code', $avenue->postal_code) }}">
            </div>
            <div class="col-md-3 form-group">
                <label>Latitude</label>
                <input name="latitude" class="form-control" value="{{ old('latitude', $avenue->latitude) }}">
            </div>
            <div class="col-md-3 form-group">
                <label>Longitude</label>
                <input name="longitude" class="form-control" value="{{ old('longitude', $avenue->longitude) }}">
            </div>
            <div class="col-md-6 form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $avenue->status?->value ?? 'active') === $status->value)>{{ ucfirst($status->value) }}</option>
                    @endforeach
                </select>
            </div>

            @php
                $locationImages = old('existing_location_images', $avenue->location_images ?? []);
                $eventRoomImages = old('existing_event_room_images', $avenue->event_room_images ?? []);
                $buildingImages = old('existing_building_images', $avenue->building_images ?? []);
            @endphp

            <div class="col-md-12"><hr></div>

            <div class="col-md-12 form-group">
                <label>Location Images</label>
                <input type="file" name="location_images[]" class="form-control js-image-input" data-preview-target="locationImagesPreview" multiple accept="image/*">
                <small class="form-text text-muted">You can select multiple images. Wrong selected images can be removed before submit.</small>
                <div id="locationImagesPreview" class="d-flex flex-wrap mt-2"></div>

                @if(! empty($locationImages))
                    <div class="mt-2">
                        <p class="mb-1 text-muted">Existing location images:</p>
                        <div class="d-flex flex-wrap">
                            @foreach($locationImages as $imagePath)
                                <div class="position-relative border rounded p-1 mr-2 mb-2">
                                    <img src="{{ asset('storage/'.$imagePath) }}" alt="Location Image" style="width: 96px; height: 96px; object-fit: cover;">
                                    <div class="mt-1">
                                        <label class="mb-0">
                                            <input type="checkbox" name="remove_location_images[]" value="{{ $imagePath }}">
                                            Remove
                                        </label>
                                    </div>
                                    <input type="hidden" name="existing_location_images[]" value="{{ $imagePath }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-12 form-group">
                <label>Event Room Images</label>
                <input type="file" name="event_room_images[]" class="form-control js-image-input" data-preview-target="eventRoomImagesPreview" multiple accept="image/*">
                <small class="form-text text-muted">Add hall/room images. You can remove selected files before submit.</small>
                <div id="eventRoomImagesPreview" class="d-flex flex-wrap mt-2"></div>

                @if(! empty($eventRoomImages))
                    <div class="mt-2">
                        <p class="mb-1 text-muted">Existing event room images:</p>
                        <div class="d-flex flex-wrap">
                            @foreach($eventRoomImages as $imagePath)
                                <div class="position-relative border rounded p-1 mr-2 mb-2">
                                    <img src="{{ asset('storage/'.$imagePath) }}" alt="Event Room Image" style="width: 96px; height: 96px; object-fit: cover;">
                                    <div class="mt-1">
                                        <label class="mb-0">
                                            <input type="checkbox" name="remove_event_room_images[]" value="{{ $imagePath }}">
                                            Remove
                                        </label>
                                    </div>
                                    <input type="hidden" name="existing_event_room_images[]" value="{{ $imagePath }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-12 form-group">
                <label>Building Images</label>
                <input type="file" name="building_images[]" class="form-control js-image-input" data-preview-target="buildingImagesPreview" multiple accept="image/*">
                <small class="form-text text-muted">Add exterior/building photos. Wrong selected files can be removed.</small>
                <div id="buildingImagesPreview" class="d-flex flex-wrap mt-2"></div>

                @if(! empty($buildingImages))
                    <div class="mt-2">
                        <p class="mb-1 text-muted">Existing building images:</p>
                        <div class="d-flex flex-wrap">
                            @foreach($buildingImages as $imagePath)
                                <div class="position-relative border rounded p-1 mr-2 mb-2">
                                    <img src="{{ asset('storage/'.$imagePath) }}" alt="Building Image" style="width: 96px; height: 96px; object-fit: cover;">
                                    <div class="mt-1">
                                        <label class="mb-0">
                                            <input type="checkbox" name="remove_building_images[]" value="{{ $imagePath }}">
                                            Remove
                                        </label>
                                    </div>
                                    <input type="hidden" name="existing_building_images[]" value="{{ $imagePath }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('admin.avenues.index') }}" class="btn btn-secondary">Back</a>
            <button class="btn btn-primary">{{ $method === 'POST' ? 'Save Avenue' : 'Update Avenue' }}</button>
        </div>
    </form>
</div>
@stop

@section('css') @vite(['resources/css/app.css']) @stop
@section('js')
    @vite(['resources/js/app.js'])
    <script>
        (function () {
            function renderPreview(input, previewContainer) {
                const dt = new DataTransfer();
                previewContainer.innerHTML = '';

                Array.from(input.files || []).forEach((file, index) => {
                    dt.items.add(file);

                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const wrap = document.createElement('div');
                        wrap.className = 'position-relative border rounded p-1 mr-2 mb-2';
                        wrap.style.width = '104px';

                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.alt = file.name;
                        img.style.width = '96px';
                        img.style.height = '96px';
                        img.style.objectFit = 'cover';

                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn btn-danger btn-xs mt-1 w-100';
                        btn.textContent = 'Remove';
                        btn.addEventListener('click', function () {
                            const nextDt = new DataTransfer();
                            Array.from(input.files || []).forEach((f, i) => {
                                if (i !== index) {
                                    nextDt.items.add(f);
                                }
                            });
                            input.files = nextDt.files;
                            renderPreview(input, previewContainer);
                        });

                        wrap.appendChild(img);
                        wrap.appendChild(btn);
                        previewContainer.appendChild(wrap);
                    };
                    reader.readAsDataURL(file);
                });

                input.files = dt.files;
            }

            document.querySelectorAll('.js-image-input').forEach(function (input) {
                const targetId = input.getAttribute('data-preview-target');
                const previewContainer = document.getElementById(targetId);
                if (!previewContainer) {
                    return;
                }

                input.addEventListener('change', function () {
                    renderPreview(input, previewContainer);
                });
            });
        })();
    </script>
@stop
