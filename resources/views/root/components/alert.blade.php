<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </button>
    <div class="m-alert__icon">
        <i class="flaticon-exclamation m--font-{{ $type ?? '' }} m--font-brand"></i>
    </div>
    <div class="m-alert__text">
        {{ $slot }}
    </div>
</div>