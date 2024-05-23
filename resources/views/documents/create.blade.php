@extends('layouts.app')


@section('content')
    <div class="container">
        <a href="{{route('documents')}}" class="btn btn-success">Back</a>
        <br><br>
        @if(count($errors)>0)
            @foreach($errors->all() as $item)
        <div class="alert alert-danger" role="alert">
            {{$item}}
        </div>
            @endforeach
        @endif
        <div class="col-md-8">
            <form action="{{route('documents.store')}}" method="POST" enctype="multipart/form-data" >
            @csrf
                <div class="mb-3">
                    <label for="NameUser" class="form-label">Name</label>
                    <input type="text" name="name_Doc" class="form-control" id="NameUser" >
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" name="categories_id" id="category" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name_cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Upload File</label>
                    <input class="form-control" name="doc_pdf" type="file" id="formFile">
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>




</div>
@endsection
