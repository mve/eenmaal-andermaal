@extends('layouts.admin-app')

@section('content')

    <div class="container-fluid admin">
        <h1 class="text-center pt-3">Rubrieken</h1>

        <form id="rubriekenSearchForm" class="form-group text-center">
            <input type="text" class="form-control" style="width: inherit;display:inline" placeholder="Auto's">
            <input type="submit" class="btn btn-secondary" name="submit" value="Zoek"/>
        </form>

        <div class="row mb-3 offset-lg-2 offset-xl-3">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="content">
                    <div id="category-container-parent-admin">
                        <div class="row category-container" id="category_tree">
                            @php(print($categoryMenuHTML))
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 text-center">
                <h2>Acties</h2>
                <div class="card px-2 py-4">
                    <div class="card-body">

                        <div class="form-group mb-4">
                            <label for="new_category" class="col-md-11 col-form-label text-md-left">Nieuwe
                                categorie</label>

                            <div class="col-md-12">
                                <input id="new_category" type="text"
                                       class="form-control @error('new_category') is-invalid @enderror"
                                       name="new_category" value="{{ old('new_category') }}" autofocus>

                                @error('new_category')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="change_name" class="col-md-11 col-form-label text-md-left">Naam
                                wijzigen</label>

                            <div class="col-md-12">
                                <input data-selected-id="" id="change_name" type="text"
                                       class="form-control @error('change_name') is-invalid @enderror"
                                       name="change_name" value="{{ old('change_name') }}" required autofocus>

                                @error('change_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="change_order" class="col-md-11 col-form-label text-md-left">Uitgelichte
                                volgorde</label>

                            <div class="col-md-12">
                                <input data-selected-id="" id="change_order" type="number"
                                       class="form-control @error('change_order') is-invalid @enderror"
                                       name="change_order" value="{{ old('change_order') }}" autofocus>
                                @error('change_order')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="change_parent" class="col-md-11 col-form-label text-md-left">Bovenliggende
                                categorie</label>

                            <div class="col-md-12">
                                <select id="change_parent" name="change_parent"
                                        class="form-select @error('change_parent') is-invalid @enderror"
                                        aria-label="Default select example">
                                    <option data-parent-id="-1" value="-1">Root</option>
                                    @foreach ($categories as $categorie)
                                        <option data-parent-id="{{$categorie->parent_id}}" value="{{ $categorie->id }}">
                                            [{{$categorie->name_parent}}] {{ $categorie->name }}</option>
                                    @endforeach
                                </select>
                                @error('change_parent')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <button onclick="deleteBtnPressed()" class="btn btn-danger btn-lg"
                                name="delete">Verwijderen
                        </button>
                        <button onclick="applyBtnPressed()" class="btn btn-success btn-lg"
                                name="submit">Toepassen
                        </button>

                    </div>
                </div>

            </div>
        </div>

        <div class="m-4 position-fixed right-0 bottom-0">
            <div id="alert" style="opacity: 0; transition: 1s; background-color: #404040"
                 class="px-4 toast d-flex align-items-center text-secondary border-0" role="alert" aria-live="assertive"
                 aria-atomic="true">
                <div class="toast-body" id="toast-body">
                    De categorie is gewijzigd!
                </div>
            </div>
        </div>

        <script>

            pageLoaded();


            var xhttp = new XMLHttpRequest();

            function categorySelected() {


                let _token = document.getElementsByName("_token")[0].value;

                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.response).data;

                        let change_name = document.getElementById("change_name");
                        let change_order = document.getElementById("change_order");
                        change_order.value = data.manual_order;
                        change_name.value = data.name;
                        change_name.setAttribute('data-selected-id', data.id);

                        document.getElementById("change_parent").value = data.parent_id;

                    }
                };

                xhttp.open("GET", "/admin/categories/" + window.event.target.id, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("_token=" + _token);
            }

            function applyBtnPressed() {
                let _token = document.getElementsByName("_token")[0].value;
                let new_category = document.getElementById("new_category");
                let change_name = document.getElementById("change_name");
                let change_parent = document.getElementById("change_parent");
                let change_order = document.getElementById("change_order");

                if (new_category.value.length > 0) {
                    // Nieuwe categorie aanmaken

                    // Loading screen

                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.response);

                            if (data.success) {
                                window.location.replace("/admin/categories?status=success&type=new");
                            }

                            if (data.error) {
                                window.location.replace("/admin/categories?status=error&type=new");
                            }

                        }
                    };

                    xhttp.open("POST", "/admin/categories", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("_token=" + _token + "&new_category=" + new_category.value + "&change_parent=" + change_parent.value + "&new_order=" + change_order.value);
                } else {
                    // Categorie bijwerken

                    // Loading screen

                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.response);

                            if (data.success) {
                                window.location.replace("/admin/categories?status=success&type=update");
                            }

                            if (data.error) {
                                window.location.replace("/admin/categories?status=error&type=update");
                            }

                        }
                    };

                    xhttp.open("PATCH", "/admin/categories/" + change_name.dataset.selectedId, true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("_token=" + _token + "&new_name=" + change_name.value + "&new_parent=" + change_parent.value + "&new_order=" + change_order.value);
                }
            }

            function deleteBtnPressed() {
                let _token = document.getElementsByName("_token")[0].value;
                let change_name = document.getElementById("change_name");
                let change_parent = document.getElementById("change_parent");

                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.response);

                        if (data.success) {
                            window.location.replace("/admin/categories?status=success&type=delete");
                        }

                        if (data.error) {
                            window.location.replace("/admin/categories?status=error&type=delete");
                        }

                    }
                };

                xhttp.open("DELETE", "/admin/categories/" + change_name.dataset.selectedId, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("_token=" + _token + "&new_name=" + change_name.value + "&new_parent=" + change_parent.value);
            }

            function pageLoaded() {
                var url_string = window.location.href;
                var url = new URL(url_string);
                var responseStatus = url.searchParams.get("status");
                var responseType = url.searchParams.get("type");

                if (responseType == "delete") {

                    if (responseStatus == "success") {
                        document.getElementById('toast-body').innerHTML = '<i class="far fa-check-circle"></i> Categorie verwijderd';
                        document.getElementById('alert').style.opacity = 1;

                        setTimeout(function () {
                            document.getElementById('alert').style.opacity = 0;
                        }, 5000);
                    }

                    if (responseStatus == "error") {
                        document.getElementById('toast-body').innerHTML = '<i class="far fa-check-circle"></i> Categorie kan niet verwijderd worden zorg dat deze categorie leeg is voordat je hem verwijderd';
                        document.getElementById('alert').style.opacity = 1;

                        setTimeout(function () {
                            document.getElementById('alert').style.opacity = 0;
                        }, 5000);
                    }
                }

                if (responseType == "new") {

                    if (responseStatus == "success") {
                        document.getElementById('toast-body').innerHTML = '<i class="far fa-check-circle"></i> Nieuwe categorie aangemaakt';
                        document.getElementById('alert').style.opacity = 1;

                        setTimeout(function () {
                            document.getElementById('alert').style.opacity = 0;
                        }, 5000);
                    }

                    if (responseStatus == "error") {
                        document.getElementById('toast-body').innerHTML = '<i class="far fa-check-circle"></i> Fout bij het aanmaken van een nieuwe categorie';
                        document.getElementById('alert').style.opacity = 1;

                        setTimeout(function () {
                            document.getElementById('alert').style.opacity = 0;
                        }, 5000);
                    }
                }


                if (responseType == "update") {

                    if (responseStatus == "success") {
                        document.getElementById('toast-body').innerHTML = '<i class="far fa-check-circle"></i> Categorie is bijgewerkt';
                        document.getElementById('alert').style.opacity = 1;

                        setTimeout(function () {
                            document.getElementById('alert').style.opacity = 0;
                        }, 5000);
                    }

                    if (responseStatus == "error") {
                        document.getElementById('toast-body').innerHTML = '<i class="far fa-check-circle"></i> Fout bij het bijwerken van een nieuwe categorie';
                        document.getElementById('alert').style.opacity = 1;

                        setTimeout(function () {
                            document.getElementById('alert').style.opacity = 0;
                        }, 5000);
                    }
                }

            }


        </script>

@endsection
