<div class="form-group row mb-2 form-phone-number" p-id="{{$i}}">
    <label for="phone_number" class="col-md-4 col-form-label text-md-right">Telefoonnummer</label>

    <div class="col-md-6 col-9">
        <input id="phone_number" type="tel"
               class="form-control @error('phone_number') is-invalid @enderror"
               name="phone_number[]"
               value="{{ $phoneNumber }}"
               autocomplete="phone_number" required>

        @if($errors->has("phone_number.$i"))
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $errors->get("phone_number.$i")[0] }}</strong>
        </span>
        @endif
    </div>
    <div class="col-md-1 col">
        <a class="btn btn-danger text-white" href="javascript:void(0);" onclick="removeBtnClick(event,{{$i}});"><i class="fas fa-trash"></i></a>
    </div>
</div>
