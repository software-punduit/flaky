<x-app-layout>

    @push('css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush


    <x-content-header title="Transactions"></x-content-header>

    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-status-alert></x-status-alert>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Transactions</h3>

                            <div class="card-tools">
                                @can('wallet.fund')
                                    <a href="{{ route('fund-wallet.create') }}" type="button" title="Fund Wallet"
                                        class="btn btn-tool">
                                        <i class="fas fa-credit-card"></i>
                                    </a>
                                @endcan
                                @can('wallet.withdraw')
                                    <a href="{{ route('withdraw-wallet.create') }}" type="button" title="Withdraw"
                                        class="btn btn-tool">
                                        <i class="fas fa-file-download"></i>
                                    </a>
                                @endcan

                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Payer</th>
                                        <th>Payee</th>
                                        <th>Amount (£)</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                {{ $transaction->payer->name  ?? 'NA' }}
                                            </td>
                                            <td>
                                                {{ $transaction->payee->name ?? 'NA' }}
                                            </td>
                                            <td>
                                                {{ number_format($transaction->amount) }}
                                            </td>

                                            <td>
                                                {{ $transaction->payee_id == $transaction->payer_id ? 'NA' : ($transaction->payee_id == Auth::user()->id ? \App\Models\Constants::TRANSACTION_TYPE_CREDIT : \App\Models\Constants::TRANSACTION_TYPE_DEBIT) }}
                                            </td>
                                            <td>
                                                {{ $transaction->transactionCategory->name }}
                                            </td>
                                            <td
                                                class="{{ $transaction->transactionStatus->name == 'complete' ? 'text-success' : ($transaction->transactionStatus->name == 'pending' ? 'text-warning' : 'text-danger') }}">
                                                {{ $transaction->transactionStatus->name }}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div> <!-- /.container-fluild -->
    </section>
    <!-- /.content -->

    @push('js')
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}  "></script>
        <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }} "></script>
        <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

        <script>
            $(function() {
                $("#data-table").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
