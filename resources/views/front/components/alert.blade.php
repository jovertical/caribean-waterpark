<div class="woocommerce-info" id="alert">
    <div style="margin-bottom: 10px;">
        <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" 
            onclick="event.preventDefault(); document.getElementById('alert').style.display = 'none';">
            <i class="awe-icon awe-icon-close-o"></i>
        </a>
    </div>

    <p>{{ $slot }}</p>
</div>