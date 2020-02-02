<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .container{
                width: 80vw;
            }
            .api-col{
                max-height: 400px;
                overflow-y: scroll;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
             <div class="top-right links">
                {{-- <h6>LORS API</h6> --}}
             </div>

            <div class="content">
                <div class="title m-b-md">
                    LORS API
                </div>

                <div class="container">
                    <div class="row">
                            <div class="col-md-12 api-col">
                                <table class="table w-100">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Endpoint</th>
                                            <th scope="col">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <th ><code>GET /api/movies</code></th>
                                            <td> returns all movies</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <th ><code>GET /api/movies?pageSize=e.g. 10</code></th>
                                            <td> returns movies with pagination with number of movie specify in the pageSize param per pages</td>
                                        </tr>
                                        <tr>
                                            <tr>
                                            <th scope="row">4</th>
                                            <th ><code> /api/movies?budget=asc|desc</code></th>
                                            <td> returns all movies with budget sorted in the order specified</td>
                                        </tr>
                                        <tr>
                                            <tr>
                                            <th scope="row">5</th>
                                            <th ><code>GET /api/movies?runtime=asc|desc</code></th>
                                            <td> returns all movies  with runtime sorted in the order specified</td>
                                        </tr>
                                        <tr>
                                            <tr>
                                            <th scope="row">6</th>
                                            <th ><code>GET /api/movies?boxRevenue=asc|desc</code></th>
                                            <td> returns all movies  with Box Revenue sorted in the order specified</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <p>Most of these param are not mutually exclusive hence they can be combined</p>
                                        <p><code>GET /api/characters?race=Human&&gender=Female&&pageSize=10</code> <small>will return human characters that are female with 10 characters per page</small></p>
                                    </tfoot>
                                </table>

                                <table class="table w-100">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Endpoint</th>
                                            <th scope="col">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <th ><code>GET /api/characters</code></th>
                                            <td> returns all characters</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <th ><code>GET /api/characters?race=e.g. Human </code></th>
                                            <td> returns all characters of the race specified</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <th ><code>GET /api/characters?gender=e.g. Female</code></th>
                                            <td> returns all characters of the gender specified</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <th ><code>GET /api/characters?pageSize=e.g. 10</code></th>
                                            <td> returns characters with pagination with number of characters specify in the pageSize param per pages</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </body>
</html>
