<x-app-layout>

    @push('css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush


    <x-content-header title="Order"></x-content-header>

    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-status-alert></x-status-alert>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order {{ $order->order_number }}</h3>

                            <div class="card-tools">

                                {{-- <a href="{{ route('orders.create') }}" type="button" title="Add Orders"
                                        class="btn btn-link">
                                        <i class="fas fa-plus"></i>
                                        <span class="d-none d-lg-inline">Add Order</span>
                                    </a> --}}
                                @if ($order->user_id != Auth::user()->id)
                                    <form action="{{ route('orders.update', $order->id) }}" method="post"
                                        style="display: inline-block">
                                        @csrf
                                        @method('put')
                                        @if ($order->status != 'completed')
                                            <input type="hidden" name="status" value="completed">
                                            <button class="btn btn-link" title="Mark as Completed" type="submit">
                                                <i class="fas fa-check"></i>
                                                <span>
                                                    Mark as Completed
                                                </span>
                                            </button>
                                        @else
                                            <button class="btn btn-link" title="Completed" disabled>
                                                <i class="fas fa-check"></i>
                                                <span>
                                                    Completed
                                                </span>
                                            </button>
                                        @endif
                                    </form>
                                @endif

                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Unit Price (£)</th>
                                        <th>Quantity</th>
                                        <th>Total (£)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->orderItems as $orderItem)
                                        <tr>
                                            <td>
                                                {{ $orderItem->menu->name }}
                                            </td>
                                            <td>
                                                {{ number_format($orderItem->menu->price) }}
                                            </td>

                                            <td>
                                                {{ number_format($orderItem->quantity) }}
                                            </td>
                                            <td>
                                                {{ number_format($orderItem->total) }}
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
