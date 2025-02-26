
<div class="row form-group">
    
    <div class="col-sm-12">
        <div class="row">
            @foreach ($Order_Files as $Order_File)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <?php
                        if(isset($Order_File->image))
                        {
                            $image = $Order_File->image;
                            $image_path = 'svc/orders/' . $Order->id . "/";
                            $image_path.= $image;
                            ?>
                            <div class="col-sm-12 text-center p-4">
                                <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
                            </div>
                            <?php
                        }
                    ?>
                </div>
            @endforeach
            
        </div>
    </div>
</div>