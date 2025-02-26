
<div class="row justify-content-center mt-2 mb-2 form-group">
    <div class="col-sm-8">
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->name }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('email', 'Email:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->email }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('subject', 'Subject:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->subject }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('description', 'Description:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->description }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('Status', 'Status:') !!}
            </div>
            <div class="col-sm-8">
                <p>
                    <?php
                    if($Model_Data->status == 0){
                        echo "Not Replied";
                    }
                    else{
                        echo "Replied";
                    }
                    ?>
                </p>
            </div>
        </div>

        <?php
        if($Model_Data->status == 1){
        ?>

        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('Reply', 'Reply:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->reply }}</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('Replied_at', 'Replied At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->replied_at }}</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('Replied_by', 'Replied By:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $vendors_array[$Model_Data->replied_by] }}</p>
            </div>
        </div>

        <?php
        }
        else{
        ?>

        {!! Form::model($Model_Data, ['route' => ['app-user-queries.update', $Model_Data->id], 'method' => 'patch']) !!}
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('reply', 'Reply:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::textArea('reply', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="mt-4 row pb-4">
            <div class="col-sm-12 text-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('app-user-queries.index') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </div>

        {!! Form::close() !!}


        <?php
        }
        ?>


    </div>
</div>