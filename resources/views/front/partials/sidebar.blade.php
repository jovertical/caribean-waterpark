<div class="checkout-page__sidebar">
    <ul>
        <li class="{{ Request::segment(3) == 'profile' ? 'current' : '' }}">
            <a href="{{ route('front.account.profile') }}">Profile</a>
        </li>

        <li class="{{ Request::segment(3) == 'password' ? 'current' : '' }}">
            <a href="{{ route('front.account.password') }}">Password</a>
        </li>

        <li class="{{ Request::segment(3) == 'reservations' ? 'current' : '' }}">
            <a href="{{ route('front.reservations.index') }}">Reservations</a>
        </li>
    </ul>
</div>