<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container p-5">
        <form action="{{ route('posts.update',$post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="thumbnail" id="" class="form-control">
            </div>
            <div class="mb-3">
                <input type="text" name="title" id="" class="form-control" value="{{ $post->title }}"
                    placeholder="Title">
            </div>
            <div class="mb-3">
                <textarea name="body" id="" cols="30" rows="10" value="{{$post->body }}" class="form-control"
                    placeholder="Body">
                    {{ $post->body }}
                </textarea>
            </div>
            <div class="mb-3 d-grid">
                <button class="btn btn-secondary">Update</button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
