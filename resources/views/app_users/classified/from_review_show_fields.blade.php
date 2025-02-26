@if($from_review_exists == 1)

    <form method="post" role="form" id="data-search-form">

        <div class="table-responsive">

            <table class="table table-striped table-hover"  id="fromReview">

                <thead>

                <tr role="row" class="heading">

                    <td><input type="text" class="form-control" id="s_from_review" autocomplete="off" placeholder="Name"></td>

                    <td>
                        <input type="text" class="form-control" id="s_review" autocomplete="off" placeholder="Review">
                    </td>

                    <td>
                        <input type="number" class="form-control" id="s_rating" autocomplete="off" placeholder="Rating">
                    </td>

                    <td>
                        <select class="form-control" id="s_badword" >
                            <option value="-1">Select</option>
                            <option value="1">Found</option>
                            <option value="0">Not Found</option>
                        </select>
                    </td>

                </tr>

                <tr role="row" class="heading">

                    <th>Name</th>

                    <th>Review</th>

                    <th>Rating</th>

                    <th>Bad Word</th>

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

