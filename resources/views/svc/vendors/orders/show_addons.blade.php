
<div class="form-group">
    
    <div class="row">
        <div class="col-sm-12">
            <h6>Add Addons</h6>
        </div>
    </div>
    
    
    <form action="{{ route('add_addons') }}" method="post">
    @csrf
    <div class="row container1">
        <div class="col-sm-4">
            <h6>Reason</h6>
            <input type="text" name="reason[]" class="form-control">
            <input type="hidden" name="order_id" value="{{$Order->id}}" class="form-control">
            <input type="hidden" name="total" value="{{$Order->total}}" class="form-control">
            <input type="hidden" name="vat_value" value="{{$Order->vat_value}}" class="form-control">
            <input type="hidden" name="final_value" value="{{$Order->final_value}}" class="form-control">
            <input type="hidden" name="user_id" value="{{$Order->user_id}}" class="form-control">
        </div>
        <div class="col-sm-4">
            <h6>Amount</h6>
            <input type="text" name="amount[]" class="form-control">
        </div>
        <div class="col-sm-4">
            <button class="btn btn-primary add_form_field">Add</button>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Save</button>
    </form>
</div>
    
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
  

    $(document).ready(function() {
    var wrapper = $(".container1");
    var add_button = $(".add_form_field");


    $(add_button).click(function(e) {
        e.preventDefault();
       
            $(wrapper).append('<div class="col-sm-4"><h6>Reason</h6><input type="text" name="reason[]" class="form-control"></div><div class="col-sm-4"><h6>Amount</h6><input type="text" name="amount[]" class="form-control"></div><div class="col-sm-4"></div>'); //add input box
     
    });
    // $(wrapper).on("click", ".delete", function(e) {
    //     e.preventDefault();
    //     $(this).parent('div').remove();
    
    // })
 
});
  </script>
