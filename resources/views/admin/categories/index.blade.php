@extends('layouts.admin-app')

@section('content')

    <div class="container-fluid admin">
        <h1 class="text-center pt-3">Rubrieken</h1>

      <div class="row mb-3">
        <div class="col-lg-8">
            <div class="content">
                <div id="category-container-parent-admin">
                    <div class="row category-container">
                        @php(print($categoryMenuHTML))
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 text-center">
                <h2>Acties</h2>
                <div class="row rounded-top border-top pt-2 mx-1">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="">
                                    <div>
                                        <div class="form-group">
                                            <label for="new_categorie" class="col-md-11 col-form-label text-md-left">Nieuwe catergorie</label>

                                            <div class="col-md-12">
                                                <input id="new_categorie" type="text"
                                                        class="form-control @error('new_categorie') is-invalid @enderror" name="new_categorie"
                                                        value="{{ old('new_categorie') }}" required autofocus>

                                                @error('new_categorie')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="change_name" class="col-md-11 col-form-label text-md-left">Naam wijzigen</label>

                                            <div class="col-md-12">
                                                <input id="change_name" type="text"
                                                        class="form-control @error('change_name') is-invalid @enderror" name="change_name"
                                                        value="{{ old('change_name') }}" required autofocus>

                                                @error('change_name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="country_code"
                                                class="col-md-11 col-form-label text-md-left">Hoofdcatergorie wijzigen</label>

                                            <div class="col-md-12">
                                                <select name="change_parent" class="form-select @error('change_parent') is-invalid @enderror" aria-label="Default select example">
                                                    @foreach ($categories as $categorie)
                                                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('change_parent')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>
                                    <br>
                                    <button class="btn btn-danger btn-lg" type="submit" name="delete">Verwijderen</button>
                                    <button class="btn btn-success btn-lg" type="submit" name="submit">Toepasssen</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script>
        function categorySelected() {
            console.log(window.event.target.id);
        }
    </script>

@endsection
