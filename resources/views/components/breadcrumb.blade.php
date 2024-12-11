@section('meta_title')
    {{ $title }}
@endsection

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">{{ $title }}</h4>
    @if(isset($primary) || isset($parent))
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                @isset($primary)
                    <li class="breadcrumb-item">{!! $primary !!}</li>
                @endisset
                @isset($parent)
                    <li class="breadcrumb-item">{!! $parent !!}</li>
                @endisset
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    @endif
</div>
