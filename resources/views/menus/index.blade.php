<x-app-layout>

    @push('css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush


    <x-content-header title="Menu"></x-content-header>

    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-status-alert></x-status-alert>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Menu</h3>

                            <div class="card-tools">
                                @can('menu.create')
                                    <a href="{{ route('menus.create') }}" type="button" title="Add Menus"
                                        class="btn btn-link">
                                        <i class="fas fa-plus"></i>
                                        <span class="d-none d-lg-inline">Add Menus</span>
                                    </a>
                                @endcan

                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Restaurant</th>
                                        <th>Picture</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>
                                                {{ $menu->restaurant->name }}
                                            </td>
                                            <td>
                                                <img src="{{ $menu->photo_url }}" alt="{{ $menu->name }} Photo"
                                                    class="img-thumbnail" height="100px" width="100px">
                                            </td>
                                            <td>
                                                {{ $menu->name }}
                                            </td>
                                            <td>
                                                {{ $menu->price }}
                                            </td>
                                            <td class="{{ $menu->active ? 'text-success' : 'text-danger' }}">
                                                {{ $menu->active ? 'Yes' : 'No' }}

                                            </td>

                                            <td>
                                                @can('menu.update')
                                                    <form action="{{ route('menus.update', $menu->id) }}" method="post"
                                                        style="display: inline-block">
                                                        @csrf
                                                        @method('put')
                                                        @if ($menu->active)
                                                            <input type="hidden" name="active" value="0">
                                                            <button class="btn btn-danger" title="Deactivate"
                                                                type="submit">
                                                                <i class="fas fa-power-off"></i>
                                                            </button>
                                                        @else
                                                            <input type="hidden" name="active" value="1">
                                                            <button class="btn btn-primary" title="Activate" type="submit">
                                                                <i class="fas fa-power-off"></i>
                                                            </button>
                                                        @endif
                                                    </form>

                                                    <a class="btn btn-secondary"
                                                        href="{{ route('menus.edit', $menu->id) }}" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
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
