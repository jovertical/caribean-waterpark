<div class="hotel-item">
    <div class="item-media">
        <div class="image-cover">
            <img src="{{ Helper::fileUrl($available_item->item->images->first(), 'thumbnail') }}"
                alt="" style="height: 100%; width: auto;">
        </div>
    </div>
    <div class="item-body">
        <!-- Name -->
        <div class="item-title">
            <h2>
                <a href="{{ route('front.reservation.show-item', $available_item->item) }}">{{ $available_item->item->name }}</a>
            </h2>
        </div>

        <!-- Stars -->
        <div class="item-hotel-star">
            @foreach(range(1, rand(1, 5)) as $count)
                <i class="fa fa-star"></i>
            @endforeach
        </div>

        <!-- Description -->
        <div>
            <p>{!! Str::limit($available_item->item->description, 40) !!}</p>
        </div>

        <div class="item-footer">
            <!-- Rating -->
            <div class="item-rate">
                <span>{{ number_format(rand(3, 10), 1, '.', '') }}</span>
            </div>
            <div class="item-icon">
                <span class="text-warning">
                    Only <strong>{{ $available_item->calendar_unoccupied }}</strong> Left!
                </span>
            </div>
        </div>
    </div>

    <!-- Price -->
    <div class="item-price-more">
        <div class="price">one day from
            <span class="amount">
                {{ Helper::moneyString($available_item->item->price) }}
            </span>
        </div>

        <a href="{{ route('front.reservation.show-item', $available_item->item) }}?ci={{ Request::input('ci')
            }}&co={{ Request::input('co') }}&aq={{ Request::input('aq') }}&cq={{
                Request::input('cq') }}" class="awe-btn">Reserve
        </a>
    </div>

</div>