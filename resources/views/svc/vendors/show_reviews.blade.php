@if($UserReviews_exists == 1)                   

    <form method="post" role="form" id="data-search-form">

        <div class="table-responsive">

            <table class="table table-striped table-hover"  id="myDataTable3">

                <thead>
    
                    <tr role="row" class="heading">                                          
                        <td>
                            <input type="text" class="form-control" id="s_order_no" autocomplete="off" placeholder="Order No">
                        </td>              
                        <td>
                            <input type="number" class="form-control" id="s_rating" autocomplete="off" placeholder="Rating">
                        </td>                                     
                        <td>
                            <input type="text" class="form-control" id="s_review" autocomplete="off" placeholder="Comments">
                        </td> 
        
                        <td>
                            <select class="form-control" id="s_badword" >
                                <option value="-1">Select</option>
                                <option value="0">Not Found</option>
                                <option value="1">Found</option>
                                
                            </select>
                        </td>  
        
                        
        
                        <td>
                        <select class="form-control" id="s_status">
                            <option value="-1">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        </td>                                       
                    
                        <td>&nbsp;</td>
        
                    </tr>
        
                    <tr role="row" class="heading">
            			<th>Order No</th>
                        <th>Rating</th>
                        <th>Comments</th>
                        <th>Badwords</th>
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