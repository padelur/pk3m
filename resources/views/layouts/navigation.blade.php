<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	<div class="container">
		<a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">PT 3M</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mainNavbar">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
				<li class="nav-item"><a class="nav-link" href="{{ route('history') }}">Sejarah</a></li>
				<li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Produk</a></li>
				<li class="nav-item"><a class="nav-link" href="{{ route('team.index') }}">Tim</a></li>
				<li class="nav-item"><a class="nav-link" href="{{ route('careers.index') }}">Karir</a></li>
				<li class="nav-item"><a class="nav-link" href="{{ route('contact.index') }}">Kontak</a></li>
			</ul>
			<ul class="navbar-nav ms-auto">
				@auth
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							{{ Auth::user()->name }}
						</a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
							<li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
								<i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
							</a></li>
							<li><a class="dropdown-item" href="{{ route('profile.edit') }}">
								<i class="fas fa-user me-2"></i>Profil
							</a></li>
							@if(auth()->user()->isSuperAdmin())
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
								<i class="fas fa-users me-2"></i>Manajemen Admin
							</a></li>
							@endif
							<li><hr class="dropdown-divider"></li>
							<li>
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<button class="dropdown-item" type="submit">
										<i class="fas fa-sign-out-alt me-2"></i>Logout
									</button>
								</form>
							</li>
						</ul>
					</li>
				@else
					<li class="nav-item"><a class="btn btn-success" href="{{ route('login') }}">Login</a></li>
				@endauth
			</ul>
		</div>
	</div>
</nav>
