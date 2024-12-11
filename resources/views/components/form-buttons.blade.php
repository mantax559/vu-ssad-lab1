<div class="btn-group-vertical w-100 mb-3">
    <button class="btn btn-sm btn-outline-primary" name="action" type="submit" value="{{ \Mantax559\LaravelHelpers\Helpers\RedirectHelper::SaveAndClose }}">
        <i class="mdi mdi-content-save fs-15"></i> {{ __('Save') }}
    </button>
    <a class="btn btn-sm btn-primary" href="{{ route('suppliers.index') }}">
        <i class="mdi mdi-arrow-left-bold fs-15"></i> {{ __('Back') }}
    </a>
</div>
