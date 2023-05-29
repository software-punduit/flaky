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
                             <h3 class="card-title">Edit User</h3>
                         </div>
                         <!-- /.card-header -->
                         <!-- form start -->

                         <form action="{{ route('users.update', $user->id) }}" method="POST">
                             @csrf
                             @method('put')


                             <div class="card-body">
                                 <div class="form-group">
                                     <label for="name">Name</label>
                                     <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         id="name" placeholder="Enter name"
                                         value="{{ old('name', $user->name) }}" name="name" required>
                                     @error('name')
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
