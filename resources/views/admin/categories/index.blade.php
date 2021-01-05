@extends('layouts.admin-app')

@section('content')

<div class="container-fluid admin">
    <h1 class="text-center pt-3">Rubrieken</h1>

    <div class="row mb-3">
        <div class="col-lg-8">
            <div class="content">
                <div id="category-container-parent-admin">
                    <div class="row category-container" id="category_tree">
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


                            <div class="form-group mb-4">
                                <label for="new_category" class="col-md-11 col-form-label text-md-left">Nieuwe
                                    catergorie</label>

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
                                <label for="change_parent" class="col-md-11 col-form-label text-md-left">Bovenliggende
                                    categorie</label>

                                <div class="col-md-12">
                                    <select id="change_parent" name="change_parent"
                                        class="form-select @error('change_parent') is-invalid @enderror"
                                        aria-label="Default select example" >
                                        @foreach ($categories as $categorie)
                                        <option data-parent-id="{{$categorie->parent_id}}" value="{{ $categorie->id }}">[{{$categorie->name_parent}}] {{ $categorie->name }}</option>
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
                                name="delete">Verwijderen</button>
                            <button onclick="applyBtnPressed()" class="btn btn-success btn-lg"
                                name="submit">Toepasssen</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="m-4 position-fixed right-0 bottom-0">
        <div id="alert" style="opacity: 0; transition: 1s; background-color: #404040" class="px-4 toast d-flex align-items-center text-secondary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body" id="toast-body">
                De categorie is gewijzigd!
            </div>
        </div>
    </div>

    <script>
        var xhttp = new XMLHttpRequest();
          function categorySelected() {
           

            let _token = document.getElementsByName("_token")[0].value;

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.response).data;

                    let change_name = document.getElementById("change_name");
                    change_name.value = data.name;
                    change_name.setAttribute('data-selected-id', data.id);

                    document.getElementById("change_parent").value = data.parent_id;

                }
            };

            xhttp.open("GET", "/admin/categories/" + window.event.target.id, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("_token="+_token);
        }

        function applyBtnPressed() {
            let _token = document.getElementsByName("_token")[0].value;
            let new_category = document.getElementById("new_category");
            let change_name = document.getElementById("change_name");
            let change_parent = document.getElementById("change_parent");

            if(new_category.value.length > 0) {
                // Nieuwe categorie aanmaken

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.response);

                        // var data = JSON.parse(this.response).data;
                        // console.log(data);
                    }
                };

                xhttp.open("POST", "/admin/categories", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("_token=" + _token + "&new_category=" + new_category.value + "&change_parent=" + change_parent.value);
            } else {
                // Categorie bijwerken

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.response).data;
                        
                        document.getElementById('alert').style.opacity = 1;
                        document.getElementById('toast-body').innerHTML = '<i class="far fa-check-circle"></i> test';
                        document.getElementById('category_tree').innerHTML = data.categoryMenuHTML;
                        
                        setTimeout(function () {
                            document.getElementById('alert').style.opacity = 0;
                        }, 5000);
                        
                        location.reload();
                        // var data = JSON.parse(this.response).data;
                        // console.log(data);

                    }
                };

                xhttp.open("PATCH", "/admin/categories/" + change_name.dataset.selectedId, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("_token=" + _token + "&new_name=" + change_name.value + "&new_parent=" + change_parent.value);
            }
        }

        function deleteBtnPressed() {
            console.log('delete button is pressed.');
            let _token = document.getElementsByName("_token")[0].value;
            let new_category = document.getElementById("new_category");
            let change_name = document.getElementById("change_name");
            let change_parent = document.getElementById("change_parent");

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.response).data;
                    
                    console.log(data);

                }
            };
            
            xhttp.open("DELETE", "/admin/categories/" + change_name.dataset.selectedId, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("_token=" + _token + "&new_name=" + change_name.value + "&new_parent=" + change_parent.value);
        }

     
    </script>

    @endsection
