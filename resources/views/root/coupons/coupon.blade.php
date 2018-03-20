<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <span>
            <img src="{{ Helper::fileUrl($coupon, 'thumbnail') }}" class="img-fluid rounded-circle">
        </span>
    </td>
    <td>{{ $coupon->name }}</td>
    <td>{!! Str::limit($coupon->description, 25) !!}</td>
    <td>{{ Helper::moneyString($coupon->amount_deductable) }}</td>
    <td>{{ $coupon->valid_from }}</td>
    <td>{{ $coupon->valid_until }}</td>
    <td>
        {{ $coupon->active ? 1 : 2 }}
    </td>
    <td>
        <span class="d-flex" style="overflow: visible;">
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown"><i class="la la-ellipsis-h"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" data-form="#toggleCoupon" data-action="{{ route('root.coupons.toggle', 
                        $coupon) }}" data-toggle="modal" data-target="#toggleCouponConfirmation" class="dropdown-item toggle-coupon" title="Toggle coupon"><i class="la la-toggle-{{ $coupon->active ? 'on' : 'off' }}"></i>Toggle
                    </a>

                    <a href="{{ route('root.coupons.image', $coupon) }}" class="dropdown-item">
                        <i class="la la-image"></i> Image
                    </a>
                </div>
            </div>

            <a href="javascript:void(0);" data-form="#editCoupon" data-action="{{ route('root.coupons.edit', $coupon) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-coupon" title="Edit coupon"><i class="la la-edit"></i>
            </a>

            <a href="javascript:void(0);" data-form="#destroyCoupon" data-action="{{ route('root.coupons.destroy', 
            $coupon) }}" data-toggle="modal" data-target="#destroyCouponConfirmation" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill destroy-coupon" title="Delete coupon">
                <i class="la la-trash"></i>
            </a>
        </span>
    </td>
</tr>