@props([
    'showUrl' => null,
    'editUrl' => null,
    'deleteUrl' => null,
    'showPermission' => null,
    'editPermission' => null,
    'deletePermission' => null,
    'showLabel' => 'عرض',
    'editLabel' => 'تعديل',
    'deleteLabel' => 'حذف',
    'confirmMessage' => 'هل أنت متأكد من حذف هذا العنصر؟'
])

<div {{ $attributes->merge(['class' => 'action-btns']) }}>
    @if($showUrl)
        @if($showPermission)
            @permission($showPermission)
            <a href="{{ $showUrl }}" 
               class="btn btn-soft-info btn-icon btn-sm"
               data-bs-toggle="tooltip" 
               title="{{ $showLabel }}">
                <i class="fas fa-eye"></i>
            </a>
            @endpermission
        @else
            <a href="{{ $showUrl }}" 
               class="btn btn-soft-info btn-icon btn-sm"
               data-bs-toggle="tooltip" 
               title="{{ $showLabel }}">
                <i class="fas fa-eye"></i>
            </a>
        @endif
    @endif

    @if($editUrl)
        @if($editPermission)
            @permission($editPermission)
            <a href="{{ $editUrl }}" 
               class="btn btn-soft-primary btn-icon btn-sm"
               data-bs-toggle="tooltip" 
               title="{{ $editLabel }}">
                <i class="fas fa-edit"></i>
            </a>
            @endpermission
        @else
            <a href="{{ $editUrl }}" 
               class="btn btn-soft-primary btn-icon btn-sm"
               data-bs-toggle="tooltip" 
               title="{{ $editLabel }}">
                <i class="fas fa-edit"></i>
            </a>
        @endif
    @endif

    @if($deleteUrl)
        @if($deletePermission)
            @permission($deletePermission)
            <form action="{{ $deleteUrl }}" 
                  method="POST" 
                  class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn btn-soft-danger btn-icon btn-sm"
                        data-bs-toggle="tooltip" 
                        data-confirm="{{ $confirmMessage }}"
                        title="{{ $deleteLabel }}">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            @endpermission
        @else
            <form action="{{ $deleteUrl }}" 
                  method="POST" 
                  class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn btn-soft-danger btn-icon btn-sm"
                        data-bs-toggle="tooltip" 
                        data-confirm="{{ $confirmMessage }}"
                        title="{{ $deleteLabel }}">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        @endif
    @endif

    {{ $slot }}
</div>

