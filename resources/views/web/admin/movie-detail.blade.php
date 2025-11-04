@extends('web.admin.layouts.master')

@section('main-content')
    <h1 class="h3 mb-0 text-gray-800 mb-4" id="page-title">Data Film kkk</h1>

    <div class="card">
        <div class="card-body">
            {{-- <form> --}}
                <div class="row">
                    <div class="col-md-12 border mb-2">
                        <div class="p-1">
                            <div id="thumbnail" class="d-flex justify-content-center mb-2" style="text-center;">
                                <img id="thumb-img" src="" alt="" style="width: 100%; max-width: 500px; transform-origin:center center;">
                            </div>
                            <div class="form-group container">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="fileThumbnail" aria-describedby="uploadThumbnail">
                                        <label class="custom-file-label" for="fileThumbnail">New Thumbnail</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="button" id="uploadThumbnail" data-actionthumb="uploadThumbnail">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 border p-2">
                        <img class="mb-2" src="" alt="" id="poster-img" style="width: 100%">

                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="filePoster" aria-describedby="uploadPoster">
                                <label class="custom-file-label" for="filePoster" style="font-size: 12px">New Poster</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button" id="uploadPoster" data-actionposter="uploadPoster">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 border p-2">
                        <div class="form-group">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="" disabled selected>-- Category --</option>
                                <option value="documentary">Documentary</option>
                                <option value="fiction">Fiction</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="trailer_dacast_embed" class="control-label">Trailer Dacast Embed</label>
                                <textarea name="trailer_dacast_embed" id="trailer_dacast_embed" cols="" rows="3" class="form-control"></textarea>
                                {{-- <input type="text" class="form-control" id="trailer_dacast_embed" name="trailer_dacast_embed" placeholder=""> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="dacast_embed" class="control-label">Dacast Embed</label>
                                <textarea name="dacast_embed" id="dacast_embed" cols="" rows="3" class="form-control"></textarea>
                                {{-- <input type="text" class="form-control" id="dacast_embed" name="dacast_embed" placeholder=""> --}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="age" class="control-label">Age</label>
                            <select name="age" id="age" class="form-control">
                                <option value="" disabled selected>-- Age --</option>
                                <option value="SU">SU</option>
                                <option value="13+">13+</option>
                                <option value="17+">17+</option>
                                <option value="21+">21+</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="duration" class="control-label">Duration (minute)</label>
                            <input type="number" class="form-control" id="duration" name="duration" placeholder="">
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="description" class="control-label">Description</label>
                                <textarea name="description" id="description" cols="" rows="3" class="form-control"></textarea>
                                {{-- <input type="text" class="form-control" id="description" name="description" placeholder=""> --}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="release_date" class="control-label">Release Date</label>
                            <input type="date" class="form-control" id="release_date" name="release_date" placeholder="">
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="actor" class="control-label">Actor</label>
                                <textarea name="actor" id="actor" cols="" rows="3" class="form-control"></textarea>
                                {{-- <input type="text" class="form-control" id="actor" name="actor" placeholder=""> --}}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label for="writter" class="control-label">Writter</label>
                                <textarea name="writter" id="writter" cols="" rows="3" class="form-control"></textarea>
                                {{-- <input type="text" class="form-control" id="writter" name="writter" placeholder=""> --}}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label for="producer" class="control-label">Producer</label>
                                <textarea name="producer" id="producer" cols="" rows="3" class="form-control"></textarea>
                                {{-- <input type="text" class="form-control" id="producer" name="producer" placeholder=""> --}}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label for="production" class="control-label">Production</label>
                                <textarea name="production" id="production" cols="" rows="3" class="form-control"></textarea>
                                {{-- <input type="text" class="form-control" id="production" name="production" placeholder=""> --}}
                            </div>
                        </div>

                        <button class="btn btn-success" id="updateMovie" data-actioniupmov="updateMovie">Update</button>

                    </div>
                </div>
                


                    

            {{-- </form> --}}
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function () {
            Movie.movieUpdate(AdminAuth.getToken());
        });

    </script>
@endpush