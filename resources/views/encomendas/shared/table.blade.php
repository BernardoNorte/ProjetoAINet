<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>

            <th>Client ID</th>
            <th>Date</th>
            <th>Total Price</th>
            <th>Notes</th>
            <th>NIF</th>
            <th>Address</th>
            <th>Payment Type</th>
            <th>Payment Reference</th>
            <th>Status</th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
            <th>PDF</th>
            <th>Details</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($encomendas as $encomenda)
        <tr>
            <td>{{$encomenda->id}}</td>
            <td>{{$encomenda->customer_id}}</td>
            <td>{{$encomenda->date}}</td>
            <td>{{$encomenda->total_price}}</td>
            <td>{{$encomenda->notes}}</td>
            <td>{{$encomenda->nif}}</td>
            <td>{{$encomenda->address}}</td>
            <td>{{$encomenda->payment_type}}</td>
            <td>{{$encomenda->payment_ref}}</td>
            <td>{{$encomenda->status}}</td>

            
            <td class="button-icon-col"><a href="{{ route('encomendas.show', ['encomenda' => $encomenda]) }}"
                    class="btn btn-secondary"><i class="fas fa-eye"></i></a>
            </td>
            <td class="button-icon-col"><a href="{{ route('encomendas.edit', ['encomenda' => $encomenda]) }}"
                    class="btn btn-dark"><i class="fas fa-edit"></i></a>
            </td>
            <td class="button-icon-col">
                <a href="{{ route('pdf.index', ['encomenda' => $encomenda]) }}" class="btn btn-primary" target="_blank">
                    <i class="far fa-file-pdf"></i>
                </a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>