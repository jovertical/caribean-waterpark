<footer id="footer-page">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="widget widget_contact_info">
                    <div class="widget_background">
                        <div class="widget_background__half">
                            <div class="bg"></div>
                        </div>
                        <div class="widget_background__half">
                            <div class="bg"></div>
                        </div>
                    </div>

                    <div class="logo"><img src="/front/assets/images/logo-footer.png" alt=""></div>
                    <div class="widget_content">
                        <p>Sitio Abo, Brgy. Pulong Sampaloc, Doña Remedios Trinidad, Bulakan</p>
                        <p>+1-888-8765-1234</p>
                        <a href="#">
                            <span class="__cf_email__" data-cfemail="13707c7d6772706753747c7572613d707c7e">
                                {{ config('mail.from.address') }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="widget widget_about_us">
                    <h3>About Us</h3>
                    <div class="widget_content">
                        <p>Set 1 km from buses at Baliuag Transit Sub-Terminal, this relaxed, pirate-themed resort is 6 km from events and displays at Bustos Heritage Park and 8 km from cultural attraction Museo ng Baliuag.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="widget widget_categories">
                    <h3>Services</h3>
                    <ul>
                        <li>
                            <a href="{{ route('front.items.index') }}">Accomodations</a>
                        </li>
                        <li>
                            <a href="{{ route('front.items.index') }}">Facilities</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2">
                <div class="widget widget_recent_entries">
                    <h3>Useful links</h3>
                    <ul>
                        <li>
                            <a href="{{ route('front.contact') }}">Contact Us</a>
                        </li>
                        <li>
                            <a href="{{ route('front.terms') }}">Terms &amp; Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <div class="widget widget_follow_us">
                    <div class="widget_content">
                        <p>For Special booking request, please call</p>
                        <span class="phone">099-099-000</span>
                        <div class="awe-social">
                            <a href="#"><i class="fa fa-twitter"></i></a> 
                            <a href="#"><i class="fa fa-pinterest"></i></a> 
                            <a href="#"><i class="fa fa-facebook"></i></a> 
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright"><p>&copy {{ config('app.name') }}</p></div>
    </div>
</footer>