<div class="row form-group">

    <div class="col-sm-12">
        <div class="row">

            <?php

            $count = 0;
            ?>
            <div class="table-responsive">
                <div class="table-container">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr role="row" class="heading">
                            <th>#</th>
                            <th>Home Item</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <?php
                            $count++;
                            ?>
                            <tr>
                                <td>
                                    {!! $count !!}
                                </td>
                                <td>
                                    {!! $item->item_title !!}
                                </td>
                                <td>
                                    {{ $item->order_quantity }}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>