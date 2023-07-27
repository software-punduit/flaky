<x-app-layout>
    <x-content-header title="Orders"></x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        @forelse ($menuItems as $menuItem)
                            <div class="col-md-6">
                                <div class="card" style="width: 18rem;">
                                    <img height="200px" src="{{ $menuItem->photo_url }}" class="card-img-top"
                                        alt="image of {{ $menuItem->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            {{ $menuItem->name }}
                                            {{-- &nbsp; --}}
                                            <small>
                                                £{{ number_format($menuItem->price) }}
                                            </small>
                                        </h5>
                                        
                                        <p class="card-text text-muted">
                                            {{ $menuItem->restaurant->name }}
                                        </p>
                                        <button class="btn btn-primary">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <strong>Note!</strong> Nothing here for now, check back later.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
                <div class="col-md-3">
                    <x-status-alert></x-status-alert>
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Order Cart</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form action="{{ route('menus.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="form-group"></div>

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
