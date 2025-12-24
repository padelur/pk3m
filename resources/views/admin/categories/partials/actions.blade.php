@php
	$canEdit = auth()->user()->hasPermission('categories.edit');
	$canDelete = auth()->user()->hasPermission('categories.delete');
@endphp

<div class="btn-group" role="group">
	@if($canEdit)
	<a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
		<i class="fas fa-edit"></i>
	</a>
	@endif
	@if($canDelete)
	<form method="post" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
		@csrf @method('DELETE')
		<button class="btn btn-sm btn-danger">
			<i class="fas fa-trash"></i>
		</button>
	</form>
	@endif
</div>
