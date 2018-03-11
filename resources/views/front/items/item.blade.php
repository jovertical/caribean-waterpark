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
                <a href="{{ route('front.items.show', $available_item->item) }}">{{ $available_item->item->name }}</a>
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
                <i class="awe-icon awe-icon-gym"></i>
                <i class="awe-icon awe-icon-car"></i>
                <i class="awe-icon awe-icon-food"></i>
                <i class="awe-icon awe-icon-level"></i>
                <i class="awe-icon awe-icon-wifi"></i>
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
        <a href="#" class="awe-btn">Add</a>
    </div>
</div>