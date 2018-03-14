<div class="checkout-page__sidebar">
    <ul>
        <li class="{{ Request::segment(2) == 'profile' ? 'current' : '' }}">
            <a href="{{ route('front.profile') }}">Profile</a>
        </li>

        <li class="{{ Request::segment(2) == 'settings' ? 'current' : '' }}">
            <a href="{{ route('front.settings') }}">Settings</a>
        </li>

        <li class="{{ Request::segment(2) == 'reservations' ? 'current' : '' }}">
            <a href="{{ route('front.reservations.index') }}">Reservations</a>
        </li>
    </ul>
</div>