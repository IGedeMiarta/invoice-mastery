<form class="forms-sample" wire:submit.prevent='save' method="POST">
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control @error('email')
            is-invalid
        @enderror"
            id="exampleInputEmail1" placeholder="Email" wire:model='email'>
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control @error('password')
            is-invalid
        @enderror"
            id="exampleInputPassword1" autocomplete="current-password" placeholder="Password" wire:model='password'>
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-check form-check-flat form-check-primary" wire:ignore>
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" wire:model='remember'>
            Remember me
        </label>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0">Login</button>
    </div>
    {{-- <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign
        up</a> --}}
</form>
