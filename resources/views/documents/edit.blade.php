@extends('layouts.app')


@section('content')
    <div class="container">
        <a href="{{route('documents')}}" class="btn btn-success">Back</a>
        <br><br>
        <div class="col-md-8">
            <form action="{{route('documents.update', $document->id)}}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="NameUser" class="form-label">Name</label>
                    <input type="text" name="name_Doc" class="form-control" id="NameUser" value="{{$document->name_Doc}}" >
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" name="categories_id" id="category" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{($category->id==$document->categories_id) ? 'selected': ''}} >{{$category->name_cat}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Upload File</label>
                    <input class="form-control" name="doc_pdf" type="file" id="formFile">
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>




    </div>
@endsection
