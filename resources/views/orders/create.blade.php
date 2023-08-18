<x-app-layout>
    <x-content-header title="Orders"></x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <x-status-alert></x-status-alert>
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Order Cart</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf

                            <div class="card-body cart">


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->


                </div>

                <div class="col-md-6">
                    <div class="row">
                        @forelse ($menuItems as $menuItem)
                            <div class="col-md-6">
                                <div class="card">
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

                                    </div>
                                    <button class="btn btn-primary add-to-cart-btn" data-id="{{ $menuItem->id }}"
                                        data-name="{{ $menuItem->name }}" data-price="{{ $menuItem->price }}">Add to
                                        Cart</button>

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
            </div>
        </div>
        </div>
    </section>

    <!-- /.content -->
    @push('js')
        <script>
            $(document).ready(function() {
                let addedItems = []
                $('.add-to-cart-btn').click(function(e) {
                    e.preventDefault();
                    let data = $(this).data();
                    let itemId = `item${data.id}`
                    // console.log(itemId)

                    if (addedItems.includes(data.id)) {
                        let quantityField = $('#' + itemId + ' .quantity')
                        let quantity = Number(quantityField.val());
                        // console.log(quantity)
                        quantityField.val(++quantity)
                        quantityField.trigger('change')
                    } else {

                        let inputHtml = `<div id = "${itemId}" class="form-group row">
                        <div class="col-md-4">
                            <input class="form-control" name="product_names[]" type="text" value="${data.name}" readonly>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control price" name="product_prices[]" type="number" value="${data.price}" readonly>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control quantity" name="product_quantities[]" type="number" value="1">
                        </div>
                        <div class="col-md-2">
                            <span class="sub-total">
                            £ ${data.price}
                            </span>
                        </div>
                        <div class="col-md-2">
                            <button class="delete-item btn btn-default">
                                <span class="fas fa-trash text-danger">
                                </span> 
                            </button>
                            <input name="product_ids[]" type="hidden" value="${data.id}">
                        </div>

                        </div>`
                        $('.cart').append(inputHtml);
                            addedItems.push(data.id)
                    }

                });
                $('form').on('change', '.quantity', function(e) {
                    e.preventDefault();
                    let quantityField = $(this)
                    let quantity = Number(quantityField.val())
                    let price = quantityField.parent().prev().children('.price').first().val()
                    let subtotalField = quantityField.parent().next().children('.sub-total').first()
                    let subtotal = quantity * price
                    subtotalField.text(` £ ${subtotal.toLocaleString()}`);
                    console.log(price)
                });
            });
        </script>
    @endpush
</x-app-layout>
