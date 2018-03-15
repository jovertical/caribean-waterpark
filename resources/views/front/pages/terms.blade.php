@extends('front.layouts.main')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <h1>Terms of Service</h1>

                <p>{{ config('app.name') }} is a relaxing, pirate-themed resort that is 6 km from events and displays at Bustos Heritage Park and 8 km from cultural attraction Museo ng Baliuag. We offer quality services at an affordable price.</p>

                <h3>Agreement</h3>
                <ol>
                    <li>
                        <p>These terms are not permanent and will change over time.</p>
                    </li>
                    <li>
                        <p>By using this system the user agees to these terms and conditions.</p>
                    </li>
                </ol>

                <h3>Privacy &amp; Security</h3>
                <ol>
                    <li>
                        <p>Personal data is very important for everyone, that is why we are ensuring our users that any data they shared will be protected/limited by the system from being exposed to the public specially the most sensitive piece of information.</p>
                    </li>

                    <li>
                        <p>{{ config('app.name') }} collects and uses your information, therefore using this website, you are giving us the consent to do so.</p>
                    </li>

                    <li>
                        <p>{{ config('app.name') }} will only use, process your information for the normal operation of this system.
                        Using the {{ config('app.name') }}'s Paypal express payment gateway, you agree that entering your paypal account information is within your own consent and responsibility.</p>
                    </li>

                    <li>
                        <p>By registering, users are allowing us to send information necessary to provide ease of use and also promote our services to our end users.</p>
                    </li>
                </ol>

                <h3>User Responsibilities</h3>
                <ol>
                    <li>
                        <p>The user is responsible for the ownership of content (text, photos, reviews, etc.) they have uploaded to
                        {{ config('app.name') }}. They ensure that they have all the rights to the content they have published.</p>
                    </li>

                    <li>
                        <p>The user ensures not to generate content using {{ config('app.name') }} that:</p>
                    </li>
                    <ul>
                        <li>
                            <p>is to much offensive for the resort and/or other users.</p>
                        </li>
                        <li>
                            <p>does not embody copyright of a particular data.</p>
                        </li>
                        <li>
                            <p>violates laws in any way</p>
                        </li>
                        <li>
                            <p>does not have relation for the reviewed item.</p>
                        </li>
                        <li>
                            <p>is a form of advertisement disguised as a review.</p>
                        </li>
                        <li>
                            <p>is aimed to collect or use personal data from other users.</p>
                        </li>
                    </ul>

                    <li>
                        <p>If the user breaks one of these conditions in a reasonable level, {{ config('app.name') }}
                        has the right to remove the content without any excuse, and worse disable the user's account from the system.</p>
                    </li>
                </ol>

                <h3>Termination</h3>
                <p>{{ config('app.name') }} has the right to deactivate user accounts without the consent of its users. The end user can also do that.</p>
            </div>
        </div>
    </section>

    <div style="margin-bottom: 500px;"></div>
@endsection