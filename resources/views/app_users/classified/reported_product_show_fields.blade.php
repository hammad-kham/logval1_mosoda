@if($reported_product_exists == 1)

<form method="post" role="form" id="data-search-form">

    <div class="table-responsive">

        <table class="table table-striped table-hover"  id="reportedProduct">

            <thead>

            <tr role="row" class="heading">

                <td>
                    <input type="text" class="form-control" id="s_title_2" autocomplete="off" placeholder="Title">
                </td>

                <td>
                    <input type="number" class="form-control" id="s_price_2" autocomplete="off" placeholder="Price">
                </td>

                <td>
                    <input type="text" class="form-control" id="s_product_type_2" autocomplete="off" placeholder="Product Type">                    
                </td>

                <td>
                    <input type="text" class="form-control" id="s_condition_type_2" autocomplete="off" placeholder="Condition Type">
                </td>

                <td>
                    <select class="form-control" id="s_is_sold_2" >
                        <option value="-1">Select</option>
                        <option value="1">Sold</option>
                        <option value="0">UnSold</option>
                    </select>
                </td>

                <td>
                    <select class="form-control" id="s_status_2" >
                        <option value="-1">Select</option>
                        <option value="1">Active</option>
                        <option value="0">In Active</option>
                    </select>
                </td>

                <td>
                    <input type="text" class="form-control" id="s_reason" autocomplete="off" placeholder="Reason">
                </td>

                <td>
                    <input type="date" name="s_report_time" id="s_report_time" autocomplete="off" class="form-control">
                </td>

            </tr>

            <tr role="row" class="heading">

                <th>Title</th>

                <th>Price</th>

                <th>Product Type</th>

                <th>Condition</th>

                <th>Is Sold</th>

                <th>Status</th>

                <th>Reason</th>

                <th>Report Time</th>

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

