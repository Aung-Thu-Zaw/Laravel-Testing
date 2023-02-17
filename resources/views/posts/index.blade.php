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

<body class="bg-light">
    <div class="container-fluid p-5">
        @if(auth()->user()->is_admin)
        <a href="{{ route('posts.create') }}" class="btn btn-secondary my-3">Create</a>
        @endif
        <table class="table table-striped table-hover table-bordered shadow-sm">
            <thead>
                <tr>
                    <th scope="col">ID#</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Title</th>
                    <th scope="col">Body</th>
                    <th scope="col">Views</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>
                        <img src="{{ $post->thumbnail }}" alt="" style="widht:50px; height:50px; object-fit:cover;"
                            class="rounded-3">
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->body }}</td>
                    <td>{{ $post->view }}</td>
                    <td>{{ $post->created_at->format("Y-m-d") }}</td>
                    <td>

                        @if(auth()->user()->is_admin)
                        <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-info">
                            Edit
                        </a>
                        @endif
                    </td>
                </tr>
                @empty

                <p class="text-center text-danger">Post Not Found!</p>

                @endforelse
            </tbody>
        </table>
        {{ $posts->links() }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
