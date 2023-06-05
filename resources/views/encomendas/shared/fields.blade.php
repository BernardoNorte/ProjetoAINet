@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="mb-3 form-floating">
    <label for="inputCustomerId" class="form-label">Customer Id</label>
    <input class="form-control" name="customer_id" id="inputCustomerId" {{ $disabledStr }} value="{{$encomenda->customer_id}}"></input> 
</div>
<div class="mb-3 form-floating">
    <label for="inputDate" class="form-label">Date</label>
    <input type="date" class="form-control" id="inputDate" name="date" {{ $disabledStr }} value="{{$encomenda->date}}">
</div>
<div class="mb-3 form-floating">
    <label for="inputTotalPrice" class="form-label">Total Price</label>
    <input type="number" class="form-control" id="inputTotalPrice" name="total_price" {{ $disabledStr }} value="{{$encomenda->total_price}}">
</div>
<div class="mb-3 form-floating">
    <label for="inputNotes" class="form-label">Notas</label>
    <textarea name="notes" class="form-control" id="inputNotes" rows=10 {{ $disabledStr }} value="{{$encomenda->notes}}"></textarea>
</div>
<div class="mb-3 form-floating">
    <label for="inputNif" class="form-label">NIF</label>
    <input type="text" class="form-control" name="nif" id="inputNif" {{ $disabledStr }} value="{{$encomenda->nif}}">
</div>
<div class="mb-3 form-floating">
    <label for="inputAddress" class="form-label">Address</label>
    <input type="text" class="form-control" name="address" id="inputAddress" {{ $disabledStr }} value="{{$encomenda->address}}">
</div>
<div class="mb-3 form-floating">
    <label for="inputPaymentType" class="form-label">Payment Type</label>
    <select class="form-control" name="payment_type" id="inputPaymentType" {{ $disabledStr }}>
        <option {{ $encomenda->payment_type == 'Visa' ? 'selected' : ''}}>Visa</option>
        <option {{ $encomenda->payment_type == 'Mc' ? 'selected' : ''}}>Mc</option>
        <option {{ $encomenda->payment_type == 'Paypal' ? 'selected' : ''}}>Paypal</option>
    </select>
</div>
<div class="mb-3 form-floating">
    <label for="inputPaymentRef" class="form-label">Payment Reference</label>
    <input type="number" class="form-control" id="inputPaymentRef" name="payment_ref" {{ $disabledStr }} value="{{$encomenda->payment_ref}}">
</div>
