    <div class="block-content">                   
        <?php
        $addOnsTotal=0;
        if(count($Order_Details)>0)
        {
            $count = 0;

			?>        
			<div class="table-responsive"> 
	
				<div class="table-container">
	
					<table class="table table-striped table-hover">
	
						<thead>
	
							<tr role="row" class="heading">
	
								<th>#</th>  
								<th>Order ID</th>  
								<th>Item</th> 
								<th>QTY</th>
								<th>Item Value</th>                 
								<th>Discount</th>
								<th>Sub Total</th>       
								<th>Created AT</th>       
								 
										</tr>
	
									</thead>
	
									<tbody>
	
										@foreach($Order_Details as $record)
										<?php
										$count++;
										?>
	
										<tr>
	
											<td>
	
												{!! $count !!}
	
											</td>
											<td>
	
												{!! $record->order_id !!}
	
											</td>
	
											<td>
	
												{!! $record->item_name !!}
	
											</td>
	
											<td>
	
												{!!  $record->quantity !!}
	
											</td>
	
										<td>
	
										 ${!!  $record->item_value !!}
	
									 </td>
	
									 <td>
	
										 ${!!  $record->discount !!}
	
									 </td> 
	
									 <td>
	
										 ${!!  $record->total_value  !!}
									   <?php 
										 $addOnsTotal=floatval($addOnsTotal) + floatVal($record->total_value); 
	
									   ?>
									 </td>
										<td>
	
										 {!!  $record->created_at  !!}
	
									 </td>
	
								</tr>
	
								@endforeach
								<tr class="bg-muted text-light">
									<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
								  <td>&nbsp;</td>  <td>Total=</td>
									<td> ${{$addOnsTotal}}</td> <td>&nbsp;</td>
								</tr>
	
							</tbody>
	
						</table>
					</div>
	
				</div>
			<?php
		}
		else
		{
			?>
			<div class="row">
				<div class="col-sm-12">
					No records found
				</div>
			</div>
			<?php
		}
		?> 
	</div>
 
    <!-- add categories table ends here -->