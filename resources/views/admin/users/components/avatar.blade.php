<a data-bs-toggle="modal" data-bs-target="#avatar-{{ $user->id }}">
    <img src="{{ $user->avatar != null || $user->avatar != '' ? Storage::link($user->avatar) : asset('img/user.png') }}"
        class="img-fluid" alt="avatar" style="height:50px;">
</a>

<div class="modal fade" id="avatar-{{ $user->id }}" tabindex="-1" aria-labelledby="UsersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">{{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ $user->avatar != null || $user->avatar != '' ? Storage::link($user->avatar) : asset('img/user.png') }}"
                    class="img-fluid" alt="avatar" style="width:100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
