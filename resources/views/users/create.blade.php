 <x-app-layout>
     <x-content-header title="Users"></x-content-header>

     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-6 offset-md-3">
                     <x-status-alert></x-status-alert>
                     <!-- general form elements -->
                     <div class="card card-primary">
                         <div class="card-header">
                             <h3 class="card-title">Create User</h3>
                         </div>
                         <!-- /.card-header -->
                         <!-- form start -->

                         <form action="{{ route('users.store') }}" method="POST">
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
                                     <label for="password">Password</label>
                                     <input type="password" class="form-control @error('password') is-invalid @enderror"
                                         id="password" placeholder="Enter password" value="{{ old('password') }}"
                                         name="password" required>
                                     @error('password')
                                         <div class="invalid-feedback">
                                             {{ $message }}
                                         </div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="password_confirmation">Confirm Password</label>
                                     <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                         id="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}"
                                         name="password_confirmation" required>
                                     @error('password_confirmation')
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
