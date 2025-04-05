<!-- resources/views/livewire/change-password.blade.php -->

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title fw-bold text-center w-100 fs-6" id="changePasswordModalLabel">
                    Change Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
            </div>
            <div class="modal-body p-4">
                <form wire:submit.prevent="changePassword" class="needs-validation">
                    <div class="mb-3 position-relative">
                        <label for="oldPassword" class="form-label fw-medium">Old Password<span class="text-danger"> *</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg @error('old_password') is-invalid @enderror"
                                   id="oldPassword"
                                   wire:model.defer="old_password"
                                   placeholder="Enter your current password"
                                   autocomplete="off">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('oldPassword')">
                                <i class="bi bi-eye" id="oldPasswordIcon"></i>
                            </button>
                        </div>
                        @error('old_password')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="newPassword" class="form-label fw-medium">New Password<span class="text-danger"> *</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg @error('new_password') is-invalid @enderror"
                                   id="newPassword"
                                   wire:model.defer="new_password"
                                   placeholder="Enter a new password"
                                   autocomplete="off">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('newPassword')">
                                <i class="bi bi-eye" id="newPasswordIcon"></i>
                            </button>
                        </div>
                        @error('new_password')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="confirmNewPassword" class="form-label fw-medium">Confirm New Password<span class="text-danger"> *</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg @error('new_password_confirmation') is-invalid @enderror"
                                   id="confirmNewPassword"
                                   wire:model.defer="new_password_confirmation"
                                   placeholder="Confirm your new password"
                                   autocomplete="off">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('confirmNewPassword')">
                                <i class="bi bi-eye" id="confirmNewPasswordIcon"></i>
                            </button>
                        </div>
                        @error('new_password_confirmation')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            Submit Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        var field = document.getElementById(fieldId);
        var icon = document.getElementById(fieldId + 'Icon');

        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
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
