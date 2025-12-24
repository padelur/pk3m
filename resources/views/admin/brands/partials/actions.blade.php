<div class="btn-group" role="group">
	<a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-warning">
		<i class="fas fa-edit"></i>
	</a>
	<form method="post" action="{{ route('admin.brands.destroy', $brand) }}" class="d-inline" onsubmit="return confirm('Hapus brand ini?')">
		@csrf @method('DELETE')
		<button class="btn btn-sm btn-danger">
			<i class="fas fa-trash"></i>
		</button>
	</form>
</div>
