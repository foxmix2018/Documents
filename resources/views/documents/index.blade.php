@extends('layouts.app')


@section('content')
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Documents</h5>
                <a href="{{route('documents.create')}}" class="btn btn-info">Create</a>
                <br><br>
@if($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{$message}}
    </div>

@endif
                <br><br>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">request ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $D=0;  @endphp

                    @foreach($documents as $docs)
                        @php $D++;  @endphp
                    <tr>
                        <th scope="row">{{$D}}</th>
                        <td>{{$docs->name_Doc}}</td>
                        <td>{{$docs->categories->name_cat}}</td>
                        <td>{{$docs->Status}}</td>
                        <td>{{$docs->created_at}}</td>
                        <td>
                            <button class="btn btn-warning showDoc" onclick="showDocument({{ $docs->id }})">Show</button>
                            <a href="{{route('documents.edit', $docs->id)}}" class="btn btn-primary">Edit</a>
                            <a href="{{route('documents.softDelete', $docs->id)}}" class="btn btn-danger">Delete</a>


                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {!!  $documents->links() !!}
            </div>
        </div>
<br><br>



        <div class="" id="documentDetails"></div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showDocument(id) {
            $.ajax({
                url: '/documents/' + id,
                method: 'GET',
                success: function(data) {
                    $('#documentDetails').html(data);
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }
    </script>
@endsection
