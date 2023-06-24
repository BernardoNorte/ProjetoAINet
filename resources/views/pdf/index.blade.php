<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            background-color: #4e73df;
            color: #FFF;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }
    </style>

</head>
<body>



<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
                <h3>{{$merged['user']['name']}}</h3>
                <h3></h3>
                <pre>
Email: {{$merged['user']['email']}}
Referencia de Pagamento: {{$merged['encomenda']['payment_ref']}}
Endereço: {{$merged['encomenda']['address']}}
<br /><br />
Data: {{$merged['encomenda']['date']}}
NIF: {{$merged['cliente']['nif']}}
Estado: {{$merged['encomenda']['status']}}
</pre>


            </td>
            <td align="center">
                <img src="img/plain_white.png" alt="Logo" width="64" class="logo"/>
            </td>
            <td align="right" style="width: 40%;">

                <h3>ImagineShirt</h3>
                <pre>
                    ImagineShirt.com

                    Leiria
                    2410-124
                    Portugal
                </pre>
            </td>
        </tr>

    </table>
</div>


<br/>

<div class="invoice">
    <h3>Especificações de Recibo #</h3>
    <table width="100%">


      </table>

      <br/>



      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
            <th>Referencia Estampa</th>
            <th>Referencia Cor</th>
            <th>Quantidade</th>
            <th>Preço Unitário €</th>
            <th>Total $</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($merged['tshirtsfilter'] as $tshirt)
            <tr>
                <td align="right">{{$tshirt['estampa_id']}}</td>
                <td align="right">{{$tshirt['color_code']}}</td>
                <td align="right">{{$tshirt['qty']}}</td>
                <td align="right">{{$tshirt['unit_price']}}</td>
                <td align="right">{{$tshirt['sub_total']}}</td>
              </tr>
            @endforeach


        </tbody>

        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="right">Total €</td>
                <td align="right">{{$merged['encomenda']['preco_total']}}</td>

        </tfoot>
      </table>
</div>
</body>
</html>
