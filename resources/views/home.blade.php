<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>URL Shortener</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body class="">
    <div class="container py-5">
        <form method="POST" action="/url" class="row col-12 g-3 align-items-center m-0">
            @csrf

            <div class="col-lg-10 text-center p-0">
                <div class="input-group">
                    <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror border rounded" placeholder="Enter your long URL" />
                    @error('url')<div class="invalid-tooltip">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-lg-2 text-center text-lg-end p-0">
                <button type="submit" class="btn btn-success">Make it short!</button>
            </div>

        </form>
    </div>

    <br>

    <div class="container">

        <div style="min-height: 60px;" class="mb-3">
            <div class="collapse" id="collapseOriginalUrl">
                <div class="row col-12 m-0 p-3 border rounded">
                    <div class="col-10 text-start p-0">
                        Your Original URL: <span id="original-url-text" class="text-primary user-select-all"></span>
                    </div>
                    <div class="col-2 text-end p-0">
                        <button type="button" class="btn-close" id="collapse-close-btn" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Short URL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($urls as $url)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><a href="#" class="url-key" onclick="getOriginalUrl('{{ $url->key }}')"> {{ URL::to('/') . '/' . $url->key }}</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No urls found.</td>
                </tr>
                @endforelse

            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $urls->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <script>
        // const URL = {{ Js::from(URL::to('/')) }};
        const URL = '<?php echo URL::to('/') ?>';
        const urlElm = document.getElementById('url');
        const bsCollapse = new bootstrap.Collapse('#collapseOriginalUrl', {
            toggle: false
        })
        const bsCollapseCloseBtn = document.getElementById('collapse-close-btn');
        const originalUrlElm = document.getElementById('original-url-text');

        urlElm.focus();

        function getOriginalUrl(key) {

            // Creating Our XMLHttpRequest object 
            var xhr = new XMLHttpRequest();

            // Making our connection  
            var url = URL + '/url/' + key;
            xhr.open("GET", url, true);

            // function execute after request is successful 
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    originalUrlElm.innerText = response.original_url ? response.original_url : 'Not found!';
                    bsCollapse.show();
                }
            }

            // Sending our request 
            xhr.send();
        }

        bsCollapseCloseBtn.addEventListener('click', (event) => {
            bsCollapse.hide();
        });
    </script>

</body>

</html>