<div class="row">
  <div class="col-xs-12">
    <label>Address (Optional)</label>
    <div class="form-group">
      <label for="line_one">Line 1</label>
      <input tabindex="1" type="text" name="line_one" class="form-control input-lg" id="line_one" placeholder="123 Fake St." value="{{ old('line_one') }}">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="form-group">
      <label for="line_two">Line 2</label>
      <input tabindex="1" type="text" name="line_two" class="form-control input-lg" id="line_two" placeholder="Apt. 2F" value="{{ old('line_two') }}">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-4">
    <div class="form-group">
      <label for="city">City</label>
      <input tabindex="1" type="text" name="city" class="form-control input-lg" id="city" placeholder="Tulsa" value="{{ old('city') }}">
    </div>
  </div>
  <div class="col-xs-4">
    <div class="form-group">
      <label for="state">State/Province</label>
      <input tabindex="1" type="text" name="state" class="form-control input-lg" id="state" placeholder="OK" value="{{ old('state') }}">
    </div>
  </div>
  <div class="col-xs-4">
    <div class="form-group">
      <label for="zip">Zip</label>
      <input tabindex="1" type="text" name="zip" class="form-control input-lg" id="zip" placeholder="90210" value="{{ old('zip') }}">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="form-group">
      <label for="country">Country</label>
      <input tabindex="1" type="text" name="country" class="form-control input-lg" id="country" placeholder="United States" value="{{ old('country') }}">
    </div>
  </div>
</div>
