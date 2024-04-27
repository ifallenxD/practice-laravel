<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h4>Countries</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCountry">Add Country</button>
                </div>
                <div class="float-end my-2">
                    
                </div>
            </div>
        </div>
        @if (count($countries) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Phone Code</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $country)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $country->name }}</td>
                            <td>{{ $country->code }}</td>
                            <td>{{ $country->phone_code }}</td>
                            <td>
                                <button type="button" class="btn btn-round btn-danger btn-sm mx-1" title="Delete Country" wire:click="$dispatch('confirmDelete',{ 'id':{{ $country->id }},'targetEvent':'country-deleted'})">Delete</button>
                                <button type="button" class="btn btn-round btn-primary btn-sm mx-1" title="Update Country" wire:click="editCountry({{$country->id}})">Update</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-primary my-2" role="alert">
                No countries available!!
            </div>
        @endif


    </div>
    
    {{-- MODALS --}}

    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addCountry">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2">Add Country</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="demo-form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="name">Country Name <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="name" wire:model="name"class="form-control"
                                    name="name" />
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="name">Country Code <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="code" wire:model="code"class="form-control"
                                    name="code" />
                                @error('code')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="name">Phone Code <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="phone_code" wire:model="phone_code"class="form-control"
                                    name="phone_code" />
                                @error('phone_code')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-2">
                                <hr>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetFields">Close</button>
                                <button type="button" class="btn btn-primary" wire:click="addCountry">add</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editCountry">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2">Update Country</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="demo-form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="name">Country Name <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="name" wire:model="name"class="form-control"
                                    name="name" />
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="name">Country Code <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="code" wire:model="code"class="form-control"
                                    name="code" />
                                @error('code')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="name">Phone Code <span class="text-danger">*</span>
                                    :</label>
                                <input type="text" id="phone_code" wire:model="phone_code"class="form-control"
                                    name="phone_code" />
                                @error('phone_code')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-2">
                                <hr>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetFields">Close</button>
                                <button type="button" class="btn btn-primary" wire:click="updateCountry">update</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
