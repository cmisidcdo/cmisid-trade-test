<div>
    <div class="globalheader">
        <h3 class="fw-bold m-0">Update Candidate</h3>
    </div>

    <section class="section dashboard mt-4">
        <div class="card shadow-sm border-0 rounded-3 p-4">
            <div class="col-md-10 mx-auto">
                <div class="card-body">
                    <button class="btn btn-outline-primary" wire:click="selectCandidate">Select Candidate</button>
                    <form wire:submit.prevent="save">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullname" wire:model="fullname" required>
                                @error('fullname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" wire:model="email" required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="contactno" class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="contactno" wire:model="contactno" required>
                                @error('contactno') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="position_id" class="form-label">Position</label>
                                <select class="form-select" id="position_id" wire:model="position_id" required>
                                    <option value="">Select Position</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->title }}</option>
                                    @endforeach
                                </select>
                                @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="office_id" class="form-label">Office</label>
                                <select class="form-select" id="office_id" wire:model="office_id" required>
                                    <option value="">Select Office</option>
                                    @foreach($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->title }}</option>
                                    @endforeach
                                </select>
                                @error('office_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="priority_group_id" class="form-label">Priority Group</label>
                                <select class="form-select" id="priority_group_id" wire:model="priority_group_id" required>
                                    <option value="">Select Priority Group</option>
                                    @foreach($priorityGroups as $priorityGroup)
                                        <option value="{{ $priorityGroup->id }}">{{ $priorityGroup->title }}</option>
                                    @endforeach
                                </select>
                                @error('priority_group_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="endorsement_date" class="form-label">Endorsement Date</label>
                                <input type="date" class="form-control" id="endorsement_date" wire:model="endorsement_date" required>
                                @error('endorsement_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" id="remarks" wire:model="remarks" rows="3"></textarea>
                                @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">Update Candidate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
