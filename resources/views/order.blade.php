<div id="myDiv">
@include('header')

<main>
  
    @include('menu')

    <div class="right-main">

        @include('topBar')

        <div class="main-wrapper">
            <div class="row page-head">
                <div class="col-md-8 page-name">
                    <h4>Order List</h4>
                </div>
                <div class="col-md-4 page-head-right text-end">
                    <button type="button" class="primary-btn custom-btn add" data-bs-toggle="modal" data-bs-target="#exampleModal">Order</button>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order Code</th>
                        <th scope="col">User</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($orders as $order)
                  <tr>
                    <td></td>
                    <td>{{$order->_id}}</td>
                    <td>{{$order->users['name']}}</td>
                    <td>{{$order->total_rate}}</td>
                    <td>
                  <button type="button" class="primary-btn custom-btn add" data-bs-toggle="modal" data-bs-target="#exampleModal2" onclick="update_view('{{$order->_id}}');">Update</button>
                  <button type="button" class="primary-btn custom-btn add" data-bs-toggle="modal" onclick="delete_order('{{$order->_id}}');">Delete</button>
                  </td>
                  </tr>
                  @endforeach
                  
                </tbody>

            </table>
            {!! $orders->links() !!}

         

        </div>
    </div>
</main>

<!-- Order Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Now</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="order_close();" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="" method="post" >
            @csrf
                <div class="row gx-4 gy-3">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Select User<span style="color:red">*</span></label>
                        <select class="form-control" name="user_id" id="user_id" onchange="user_name();">
                            <option value="" selected>Open this select menu for users</option>
                            @foreach($users as $user)
                                <option value="{{$user->_id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        <input type="text" style="display:none" class="form-control"  id="user" name="user" aria-label="First name" readonly>
                        <span style="color:red" id="useridEr"></span>
                    </div>
                   
                    <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label" >Select Product<span style="color:red">*</span></label>
                        <select class="form-control" name="product_id" id="product_id" onblur="this.value;" onchange="validate_product();">
                        <option value="" selected>Open this select menu for Product</option>
                            @foreach($products as $product)
                                <option value="{{$product->_id}}">{{$product->product_name}}</option>
                            @endforeach   
                        </select>
                        <span style="color:red" id="productIdEr"></span>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Rate<span style="color:red">*</span></label>
                        <input type="text" class="form-control" placeholder="Rate of the product" id="product_rate" onchange="get_total_rate();" oninput="validate_rate();" name="product_rate" aria-label="First name">
                        <span style="color:red" id="rateEr"></span>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Quantity<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="quantity" id="quantity" onchange="get_total_rate();"  oninput="validate_quantity();" placeholder="Type Quantity" aria-label="First name">
                        <span style="color:red" id="quantityEr"></span>
                    </div>

                    <div class="col-md-6"> 
                    <label for="exampleFormControlInput1" class="form-label">Total Rate<span style="color:red">*</span></label>  
                        <input type="text" class="form-control" placeholder="Total Rate" name="total_rate" id="total_rate" aria-label="First name" disabled>
                        <span style="color:red" id="totalrate_Er"></span>                 
                    </div>
                    <button type="button"  id="productAdd" class="custom-btn save primary-btn" onclick="productAddToCart();">Add To Cart</button>

                <div class="table1" id="table1" style="display:none">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>List Products</h2>
                    </div>
                    <div class="row">
                    <div class="col-sm-6">
                        <table id="productTable" class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Total Rate</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
</div>
<div class="col-md-6">
                        
                        <input type="hidden" class="form-control" placeholder="Total Rate" name="final_rate" id="final_rate" aria-label="First name" disabled>
                    </div>
            </div>
           
                   

                </div>
            </div>
            
            <div class="modal-footer">

                <button type="button" class="custom-btn save primary-btn" onclick="order_now();">Order</button>
            </div>
        </form>
        </div>
    </div>
</div>
</div>


<!-- Update Order Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Now</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="update_order_close();" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="" method="post" >
            @csrf
                <div class="row gx-4 gy-3">
                <input type="hidden" name="order_id" id="order_id">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">User<span style="color:red">*</span></label>
                        <input type="text"  class="form-control"  id="user_edit_id" name="user_edit_id" aria-label="First name" readonly>
                    </div>
                   <div class="row gx-4 gy-3" style="display:none" id="addnewcart">
                    <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label" >Select Product<span style="color:red">*</span></label>
                        <select class="form-control" name="product_edit_id" id="product_edit_id" onchange="validate_product_edit();">
                        <option value="" selected>Open this select menu for Product</option>
                            @foreach($products as $product)
                                <option value="{{$product->_id}}">{{$product->product_name}}</option>
                            @endforeach   
                        </select>
                        <span style="color:red" id="product_editIdEr"></span>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Rate<span style="color:red">*</span></label>
                        <input type="text" class="form-control" placeholder="Rate of the product" id="product_edit_rate" onchange="get_total_edit_rate();" oninput="validate_edit_rate();" name="product_rate" aria-label="First name">
                        <span style="color:red" id="rate_editEr"></span>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Quantity<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="edit_quantity" id="edit_quantity" onchange="get_total_edit_rate();"  oninput="validate_edit_quantity();" placeholder="Type Quantity" aria-label="First name">
                        <span style="color:red" id="quantity_editEr"></span>
                    </div>

                    <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Total Rate<span style="color:red">*</span></label>
                        <input type="text" class="form-control" placeholder="Total Rate" name="total_edit_rate" id="total_edit_rate" aria-label="First name" disabled>
                    </div>
                    <button type="button"  id="productAdd" class="custom-btn save primary-btn" onclick="UpdateCart();">Add To Cart</button>
                    <span style="color:red" id="error"></span>
                 <div>
                <div class="col-md-6">
                    <input type="hidden" class="form-control" placeholder="Total Rate" name="final_edit_rate" id="final_edit_rate" aria-label="First name" disabled>
                </div>
            </div>
                </div>
            </div>
            
            <div class="container table2" id="table2">
                <div class="row">
                 <div class="col-sm-6">
            <h2>List Products</h2>
        </div>
    </div>
    <button type="button"  id="addnew" class="custom-btn save primary-btn" onclick="addnewcart();" >Add New</button>
    <div class="row">
        <div class="col-sm-6  " id="table_data">
            
        </div>
    </div>
</div>
            </div>
            
            <div class="modal-footer">
            <button type="button"  id="save" class="custom-btn save primary-btn" onclick="save();" >Save</button>
            </div>
        </form>
        </div>
    </div>
</div>
</div>

@include('footer')
</div>
<script src="{{asset('js/order.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

