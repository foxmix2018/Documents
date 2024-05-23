

    <div class="container">


        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Request ID : {{$document->id}}</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Name:  {{$document->name_Doc}}</h6>
                <h6 class="card-subtitle mb-2 text-body-secondary">Category:  {{$document->categories->name_cat}}</h6>
                <h6 class="card-subtitle mb-2 text-body-secondary">Status:  {{$document->Status}}</h6>
                <h6 class="card-subtitle mb-2 text-body-secondary">Date and Time:  {{$document->created_at}}</h6>
                <h5 class="card-title">Digital Signature Valldation</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Status: </h6>
                <h6 class="card-subtitle mb-2 text-body-secondary">Date and Time: </h6>
                <h5 class="card-title">Status Actions</h5>
                <form action="{{route('documents.statusAppr', $document->id)}}" method="post" style="display: inline-block">
                    @csrf
                    @method('PUT')
                <button type="submit" class="btn btn-success">Approve</button>
                </form>
                <form action="{{route('documents.statusRej', $document->id)}}" method="post" style="display: inline-block">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>

                <form action="{{route('documents.download', $document->id)}}" method="post" style="display: inline-block">
                    @csrf
                    <button type="submit" class="btn btn-info">Download PDF</button>
                </form>


            </div>
        </div>
    </div>

