<!-- resources/views/livewire/change-password.blade.php -->

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title fw-bold text-center w-100 fs-6" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
            </div>
            <div class="modal-body p-3">
                <form wire:submit.prevent="changePassword" class="needs-validation">
                    <div class="mb-2">
                        <label for="oldPassword" class="form-label small fw-medium mb-1">Old Password<span class="text-danger"> *</span></label>
                        <div class="input-group input-group-sm">
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                   id="oldPassword"
                                   wire:model.defer="old_password"
                                   placeholder="Current password"
                                   autocomplete="off">
                        </div>
                        @error('old_password')
                        <div class="invalid-feedback d-block small">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="newPassword" class="form-label small fw-medium mb-1">New Password<span class="text-danger"> *</span></label>
                        <div class="input-group input-group-sm">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                   id="newPassword"
                                   wire:model.defer="new_password"
                                   placeholder="New password"
                                   autocomplete="off">
                        </div>
                        @error('new_password')
                        <div class="invalid-feedback d-block small">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="confirmNewPassword" class="form-label small fw-medium mb-1">Confirm New Password<span class="text-danger"> *</span></label>
                        <div class="input-group input-group-sm">
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                   id="confirmNewPassword"
                                   wire:model.defer="new_password_confirmation"
                                   placeholder="Confirm new password"
                                   autocomplete="off">
                        </div>
                        @error('new_password_confirmation')
                        <div class="invalid-feedback d-block small">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-check mt-3 mb-3">
                        <input class="form-check-input" type="checkbox" id="showAllPasswords" onclick="toggleAllPasswordVisibility()">
                        <label class="form-check-label small" for="showAllPasswords">
                            Show all passwords
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" wire:click="clear">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary px-3">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAllPasswordVisibility() {
        var passwordFields = ['oldPassword', 'newPassword', 'confirmNewPassword'];
        var checkbox = document.getElementById('showAllPasswords');
        
        passwordFields.forEach(function(fieldId) {
            var field = document.getElementById(fieldId);
            field.type = checkbox.checked ? "text" : "password";
        });
    }
</script>

@script
<script>
    $wire.on('hide-change-password-modal', () => {
        $('#changePasswordModal').modal('hide');
    });

    $wire.on('show-change-password-modal', () => {
        $('#changePasswordModal').modal('show');
    });
</script>
@endscript