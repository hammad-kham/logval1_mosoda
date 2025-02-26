

@if($UserOrders_exists == 1)                   

    <form method="post" role="form" id="data-search-form">

        <div class="table-responsive">

            <table class="table table-striped table-hover" id="myDataTable2">

                <thead>

                    <tr role="row" class="heading">                           
                                                                                   
                        <td>
                            <input type="text" class="form-control" id="s_order_no_2" autocomplete="off" placeholder="Order No">
                        </td>
                
                        <td>
                            <input type="number" class="form-control" id="s_order_value" autocomplete="off" placeholder="Order Value">
                        </td>
                        
                        
                        <td>
                            <select class="form-control" id="s_order_status">
                                <option value="-1">Select</option>
                                <option value="1">Waiting</option>
                                <option value="2">Canceled</option>
                                <option value="3">Confirmed</option>
                                <option value="4">Declined</option>
                                <option value="5">Accepted</option>
                                <option value="6">Completed</option>
                            </select>
                        </td>
                        <td>
                        </td>
                        
                    </tr>
                    <tr role="row" class="heading">
                		<th>Order No</th>
                        <th>Order Value</th>
                        <th>Status</th>
                        <th>Action</th>                                                    
                    </tr>
    
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </form>

@else

    <p style="text-align:center; font-weight:bold; padding:50px;">No Records Available</p>

@endif
        