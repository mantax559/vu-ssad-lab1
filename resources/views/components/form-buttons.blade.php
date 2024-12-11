@props(['previousPageModel'])

<div class="btn-group-vertical w-100 mb-3">
    <button class="btn btn-sm btn-outline-primary" name="action" type="submit" value="{{ \Mantax559\LaravelHelpers\Helpers\RedirectHelper::SaveAndClose }}">
        <i class="mdi mdi-content-save fs-15"></i> {{ __('Save') }}
    </button>
    <button class="btn btn-sm btn-outline-primary" name="action" type="submit" value="{{ \Mantax559\LaravelHelpers\Helpers\RedirectHelper::SaveAndStay }}">
        <i class="mdi mdi-content-save-edit-outline fs-15"></i> {{ __('Save & Stay') }}
    </button>
    <a class="btn btn-sm btn-primary" href="{{ session(\Mantax559\LaravelHelpers\Helpers\SessionHelper::getUrlKey($previousPageModel)) }}">
        <i class="mdi mdi-arrow-left-bold fs-15"></i> {{ __('Back') }}
    </a>
</div>
