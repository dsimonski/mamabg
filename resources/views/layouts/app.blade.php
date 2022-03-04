<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>Mama BG - @yield('title')</title>
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm mb-3">
        <h5 class="my-0 mr-md-auto font-weight-normal">
            <a class="text-dark" href="{{ route('index') }}">
                Mama BG
            </a>
        </h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="/">Начало</a>
            <a class="p-2 text-dark" href="{{ route('users.index') }}">Потребители</a>
            <a class="p-2 text-dark" href="{{ route('users.create') }}">Добави Потребител</a>
        </nav>
    </div>
    <div class="container">
        @if(session('status'))
        <div id="flashMessage" class="alert alert-success d-none">
            {{ session('status') }}
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajaxModalTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Loader -->
                    <div id="loaderHolder">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div id="ajaxModalBody">
                        ...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteModalBody">
                    ...
                </div>
                <div class="modal-footer">
                    <form id="deleteModalForm" class="d-inline" action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Изтрий!" class="btn btn-danger">
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
