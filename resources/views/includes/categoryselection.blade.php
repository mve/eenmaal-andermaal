<select class="form-select" c-level="{{$level}}" onchange="categorySelect({{$level}});" name="category[]" aria-label="Default select example">
    <option value="-2" selected>Kies rubriek</option>
    @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
    @endforeach
</select>
