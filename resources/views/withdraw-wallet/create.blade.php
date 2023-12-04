<x-app-layout>
    <x-content-header title="Withdraw"></x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <x-status-alert></x-status-alert>
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Withdraw</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form action="{{ route('withdraw-wallet.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                              
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        id="amount" placeholder="Enter Amount"
                                        value="{{ old('amount') }}" name="amount" min="0"
                                        step="0.01" required>
                                    @error('amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

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
