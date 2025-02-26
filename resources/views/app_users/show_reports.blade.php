@if($reports_exists == 1)

    <form method="post" role="form" id="data-search-form-6">

        <div class="table-responsive">

            <table class="table table-striped table-hover" id="myDataTable6">

                <thead>

                <tr role="row" class="heading">
                    <td>
                        <select class="form-control" id="s_user_id_6">
                            <option value="-1">Select</option>
                            <?php
                            foreach($users as $key => $value)
                            {
                            ?>
                            <option value="<?php echo $key;?>">
                                <?php echo $value;?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>

                    <td>
                        <select class="form-control" id="s_type_6">
                            <option value="-1">Select</option>
                            <option value="Ecommerce Product Review">Ecommerce Product Review</option>
                            <option value="Services Review">Services Review</option>
                        </select>
                    </td>

                    <td>
                        <input type="text" class="form-control" id="s_reason_5" autocomplete="off" placeholder="Reason">
                    </td>

                    <td>
                    </td>

                </tr>
                <tr role="row" class="heading">
                    <th>User</th>
                    <th>Type</th>
                    <th>Reason</th>
                    <th>Details</th>
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

