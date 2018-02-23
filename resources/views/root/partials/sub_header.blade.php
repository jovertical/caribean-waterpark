<!-- BEGIN: Subheader -->
<div class="m-subheader">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                {{ Str::ucfirst(Request::segment(count(Request::segments()))) }}
            </h3>

            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                @if(count(Request::segments()) > 1)
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('root.home') }}" class="m-nav__link m-nav__link--icon">
                           <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>

                    @for($i = 2; $i <= count(Request::segments()); $i++)
                        <li class="m-nav__separator">-</li>

                        <li class="m-nav__item">
                            <a href="{{ URL::to(implode('/',
                                array_slice(Request::segments(), 0, $i, true))) }}"
                                    class="m-nav__link"><span class="m-nav__link-text"
                                        onclick="{{ $i > 2 ? 'event.preventDefault();' : '' }}">
                                            {{ ucfirst(Request::segment($i)) }}</span>
                            </a>
                        </li>
                    @endfor
                @endif
            </ul>
        </div>

    </div>
</div>
<!-- END: Subheader -->