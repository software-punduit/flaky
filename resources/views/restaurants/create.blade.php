 <x-app-layout>
     <x-content-header title="Restaurants"></x-content-header>

     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-6 offset-md-3">
                     <x-status-alert></x-status-alert>
                     <!-- general form elements -->
                     <div class="card card-primary">
                         <div class="card-header">
                             <h3 class="card-title">Create Restaurant</h3>
                         </div>
                         <!-- /.card-header -->
                         <!-- form start -->

                         <form action="{{ route('restaurants.store') }}" method="POST">
                             @csrf

                             <div class="card-body">
                                 <div class="form-group">
                                     <label for="name">Name</label>
                                     <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         id="name" placeholder="Enter name" value="{{ old('name') }}"
                                         name="name" required>
                                     @error('name')
                                         <div class="invalid-feedback">
                                             {{ $message }}
                                         </div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="phone">Phone</label>
                                     <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                         id="phone" placeholder="Enter Phone" value="{{ old('phone') }}"
                                         name="phone" required>
                                     @error('phone')
                                         <div class="invalid-feedback">
                                             {{ $message }}
                                         </div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="email">Email</label>
                                     <input type="email" class="form-control @error('email') is-invalid @enderror"
                                         id="email" placeholder="Enter email" value="{{ old('email') }}"
                                         name="email" required>
                                     @error('email')
                                         <div class="invalid-feedback">
                                             {{ $message }}
                                         </div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="description">Description</label>
                                     <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                         placeholder="Enter Description" name="description" required>{{ old('description') }}</textarea>
                                     @error('description')
                                         <div class="invalid-feedback">
                                             {{ $message }}
                                         </div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="address">Address</label>
                                     <textarea class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Enter address"
                                         name="address" required>{{ old('address') }}</textarea>
                                     @error('address')
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
