@if($from_follow_exists == 1)

<form method="post" role="form" id="data-search-form">

    <div class="table-responsive">

        <table class="table table-striped table-hover"  id="fromFollow">

            <thead>

            <tr role="row" class="heading">

                <td>
                    <input type="text" class="form-control" id="s_from_follow" autocomplete="off" placeholder="Name">
                </td>

                <td>
                    <input type="date" name="s_follow_time_to_1" id="s_follow_time_to_1" autocomplete="off" class="form-control">
                </td>

            </tr>

            <tr role="row" class="heading">

                <th>Name</th>

                <th>Follow Time</th>

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

