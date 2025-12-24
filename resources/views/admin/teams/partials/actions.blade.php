<div class="btn-group" role="group">
	<a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-warning">
		<i class="fas fa-edit"></i>
	</a>
	<form method="post" action="{{ route('admin.teams.destroy', $team) }}" class="d-inline" onsubmit="return confirm('Hapus anggota ini?')">
		@csrf @method('DELETE')
		<button class="btn btn-sm btn-danger">
			<i class="fas fa-trash"></i>
		</button>
	</form>
</div>
