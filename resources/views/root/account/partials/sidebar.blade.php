<div class="m-portlet m-portlet--full-height">
    <div class="m-portlet__body">
        <div class="m-card-profile">
            <div class="m-card-profile__title m--hide">
                Your Profile
            </div>
            <div class="m-card-profile__pic">
                <div class="m-card-profile__pic-wrapper">
                    <img src="{{ Helper::fileUrl($superuser, 'thumbnail') }}" alt="">
                </div>
            </div>
            <div class="m-card-profile__details">
                <span class="m-card-profile__name">{{ $superuser->full_name }}</span>
                <a href="#" class="m-card-profile__email m-link">{{ $superuser->email }}</a>
            </div>
        </div>
        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
            <li class="m-nav__separator m-nav__separator--fit"></li>
            <li class="m-nav__item">
                <a href="{{ route('root.account.profile') }}" class="m-nav__link">
                <i class="m-nav__link-icon flaticon-profile-1"></i>
                    <span class="m-nav__link-text">My profile</span>
                </a>
            </li>

            <li class="m-nav__item">
                <a href="{{ route('root.account.password') }}" class="m-nav__link">
                <i class="m-nav__link-icon flaticon-lock"></i>
                    <span class="m-nav__link-text">Password</span>
                </a>
            </li>
        </ul>
    </div>
</div>