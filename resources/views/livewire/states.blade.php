<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h4>State</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addState">Add State</button>
                </div>
                <div class="float-end my-2">
                    
                </div>
            </div>
        </div>
        @if (count($states) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Country</th>
                        <th scope="col">State Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($states as $state)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $state->country->name }}</td>
                            <td>{{ $state->name }}</td>
                            <td>
                                <button type="button" class="btn btn-round btn-danger btn-sm mx-1" title="Delete State" wire:click="$dispatch('confirmDelete',{ 'id':{{ $state->id }},'targetEvent':'state-deleted'})">Delete</button>
                                <button type="button" class="btn btn-round btn-primary btn-sm mx-1" title="Update State" wire:click="editState({{$state->id}})">Update</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-primary my-2" role="alert">
                No states available!!
            </div>
        @endif
    </div>
    {{-- MODALS --}}

    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addState">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel3">Add State</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add-state">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="name">Country Name <span class="text-danger">*</span>
                                    :</label>
                                <select id="country_id" wire:model="country_id" class="form-control" name="country_id">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="name">State Name <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="name" wire:model="name"class="form-control"
                                    name="name"/>
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>                            
                            <div class="col-12 mt-2">
                                <hr>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetFields">Close</button>
                                <button type="button" class="btn btn-primary" wire:click="addState">add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editState">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel4">Edit State</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-state">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="name">Country Name <span class="text-danger">*</span>
                                    :</label>
                                <select id="country_id" wire:model="country_id" class="form-control" name="country_id">
                                    <option value="" disabled>Select Country</option>
                                    @foreach ($countries as $country)
                                        @if ($country->id == $country_id)
                                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endif 
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="name">State Name <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="name" wire:model="name"class="form-control"
                                    name="name"/>
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>                            
                            <div class="col-12 mt-2">
                                <hr>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetFields">Close</button>
                                <button type="button" class="btn btn-primary" wire:click="updateState">add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 

</div>