<x-app-layout>
    <x-content-header title="Restaurant Tables"></x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <x-status-alert></x-status-alert>
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Restaurant Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form action="{{ route('restaurant-tables.update', $restaurantTable->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" placeholder="Enter name" value="{{ old('name', $restaurantTable->name) }}"
                                        name="name" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="reservation_fee">Reservation Fee</label>
                                    <input type="number"
                                        class="form-control @error('reservation_fee') is-invalid @enderror"
                                        id="reservation_fee" placeholder="Enter Reservation Fee"
                                        value="{{ old('reservation_fee', $restaurantTable->reservation_fee) }}" name="reservation_fee" min="0"
                                        step="0.01" required>
                                    @error('reservation_fee')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="photo">Picture</label>
                                    <div class="input-group">
                                        <input type="file"
                                            class="form-control @error('photo')    
                                            @enderror"
                                            id="photo" name="photo">

                                        {{-- <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div> --}}
                                        @error('photo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="restaurant_id">Restaurant</label>
                                    <select class="form-control" @error('restaurant_id')is-invalid @enderror
                                        name='restaurant_id' id="restaurant_id" required>
                                        @foreach ($restaurants as $restaurant)
                                            <option value="{{ $restaurant->id }}"
                                                {{ old('restaurant_id', $restaurantTable->restaurant_id) == $restaurant->id ? 'selected' : '' }}>
                                                {{ $restaurant->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('restaurant_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->


                </div>
            </div>
        </div>
    </section>

    <!-- /.content -->
</x-app-layout>
