@extends('front.layouts.main')

@section('styles')
    <style>
        #map {
            height: 100vh;
            min-height: 100%;
        }
    </style>
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div id="map"></div>
                </div>

                <div class="col-md-6 col-md-offset-1">
                    <div class="contact-page__form">
                        <div class="title">
                            <span>We would like to know you</span>
                            <h2>CONTACT US</h2>
                        </div>

                        <div class="descriptions">
                            <p>We will try our best to contact you back as soon as possible.</p>
                        </div>

                        <form method="POST" action="" class="contact-form">
                            {{ csrf_field() }}

                            <div class="form-item">
                                <label for="first_name">
                                    Firstname <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                            </div>

                            <div class="form-item">
                                <label for="last_name">
                                    Lastname <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                            </div>

                            <div class="form-item">
                                <label for="name">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="form-item">
                                <label for="phone_number">
                                    Phone Number
                                </label>
                                <input type="number" name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
                            </div>

                            <div class="form-textarea-wrapper">
                                <label for="message">Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="message">{{ old('message') }}</textarea>
                            </div>

                            <div class="form-actions">
                                <input type="submit" value="Send" class="submit-contact">
                            </div>
                            <div id="contact-content"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function initMap() {
            var caribbean_waterpark = {lat: 14.9658162, lng: 121.0712403};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: caribbean_waterpark
            });
            var marker = new google.maps.Marker({
                position: caribbean_waterpark,
                map: map
            });
        }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_-LEz734chZ8nUmmBQhCxUa3jyJx-LVk&callback=initMap">
    </script>
@endsection