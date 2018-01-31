<div class="alert card {{ Session::get('message.type') }}-color z-depth-2 mb-2" role="alert">
    <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    <div class="card-body text-center alert-dismissible">
        <p class="white-text mb-0">{{ Session::get('message.content') }}</p>
    </div>
</div>