<div>
    <div class="row">
        <div class="col-md-11">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" rows="3" name="addresses[{{ $unique }}][address]">{{ old('address.'.$unique.'.address') }}</textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Postcode</label>
                        <input type="text" class="form-control" name="addresses[{{ $unique }}][postcode]"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>State</label>
                        <select class="form-control" name="addresses[{{ $unique }}][state]">
                            @foreach(DNA::getStateList() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Country</label>
                        <select class="form-control" name="addresses[{{ $unique }}][country]">
                            @foreach(DNA::getCountryList() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 text-right">
            <i class="fas fa-trash mr-2 text-red delete_address" style="cursor: pointer;line-height:5"></i>
        </div>
    </div>
    <hr>
    </div>
    