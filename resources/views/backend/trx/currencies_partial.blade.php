<select name="currency" class="form-control">
    @foreach (App\Models\Currency::all() as $currency)
    <option value="{{ $currency->id }}" @if(@$invoice->currency_id == $currency->id) selectd @endif @if(old('currency') == $currency->id) selected @endif)>{{ $currency->name }}</option>
    @endforeach
</select>