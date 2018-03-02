<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
    <div class="m-alert__icon">
        <i class="flaticon-exclamation m--font-{{ $type ?? '' }} m--font-brand"></i>
    </div>
    <div class="m-alert__text">
        {{ $slot }}
    </div>
</div>