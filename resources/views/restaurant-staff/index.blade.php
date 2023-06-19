<x-app-layout>

    @push('css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush


    <x-content-header title="Restaurant Staff"></x-content-header>

    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-status-alert></x-status-alert>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Restaurant Staff</h3>

                            <div class="card-tools">
                                <a href="{{ route('restaurant-staff.create') }}" type="button"
                                    title="Add Restaurant Staff" class="btn btn-link">
                                    <i class="fas fa-plus"></i>
                                    <span class="d-none d-lg-inline">Add Restaurant Staff</span>
                                </a>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="staff-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Restaurant</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($staffMembers as $staffMember)
                                        <tr>
                                            <td>
                                                {{ $staffMember->restaurant->name }}
                                            </td>
                                            <td>
                                                {{ $staffMember->staff->name }}
                                            </td>
                                            <td>
                                                {{ $staffMember->staff->email }}
                                            </td>
                                            <td>
                                                {{ $staffMember->staff->profile->phone }}
                                            </td>
                                            <td>
                                                {{ $staffMember->staff->profile->address }}
                                            </td>
                                            <td class="{{ $staffMember->staff->profile->active ? 'text-success' : 'text-danger' }}">
                                                {{ $staffMember->staff->profile->active ? 'Yes' : 'No' }}

                                            </td>

                                            <td>
                                                <form action="{{ route('users.update', $staffMember->staff_id) }}"
                                                    method="post" style="display: inline-block">
                                                    @csrf
                                                    @method('put')
                                                    @if ($staffMember->staff->profile->active)
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
                                                    href="{{ route('restaurant-staff.edit', $staffMember->id) }}"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
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
                $("#staff-table").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#staff-table_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
