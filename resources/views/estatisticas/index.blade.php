@extends('layout')
@section('title', 'Estatisticas')

@section('content')


    <style>
        /*  Counter Section  */

        #counter {
            background-color: #4e73df;
            color: #fff;
            display: block;
            overflow: hidden;
            text-align: center;
            padding: 1.5rem 0;
        }

        #counter .count {
            padding: 50px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            text-align: center;
        }

        .count h4 {
            color: #fff;
            font-size: 16px;
            margin-top: 0;
        }

        #counter .count .fa {
            font-size: 40px;
            display: block;
            color: #fff;
        }

        #counter .number {
            font-size: 30px;
            font-weight: 700;
            margin: 0;
        }

        /*  Pricing Section  */

        #pricing {
            background: #f7f7f7;
        }

        .pricing-items {
            padding-top: 50px;
        }

        .pricing-item {
            background: #fff;
            position: relative;
            box-shadow: 0 0 9px 0 rgba(130, 121, 121, .2);
            padding: 50px 0px;
            border-top-right-radius: 2em;
            border-bottom-left-radius: 2em;
        }

        .pricing-item.active {
            top: -50px;
        }

        .price-list li {
            list-style: none;
            margin-bottom: 15px;
        }

        .price-list .price {
            font-size: 30px;
            font-weight: bold;
        }

        .pricing-item .ribbon {
            margin: -50px 0 20px;
            display: block;
            background-color: #4e73df;
            padding: 15px 0 2px;
            opacity: 0.8;
            border-top-right-radius: 2em;
        }

        .pricing-item:hover .ribbon {
            background-color: #4e73df;
            opacity: 1;
        }

        .pricing-item.active .ribbon {
            background-color: #4e73df;
            opacity: 1;
        }

        .pricing-item .ribbon p {
            color: #fff;
            font-size: 22px;
            margin: 0 0 10px;
            font-weight: 600;
        }

        .pricing-item.active .price-list li,
        .pricing-item:hover .price-list li {
            color: #848181;
            ;
        }

        ul.price-list {
            margin-bottom: 30px;
            padding: 0;
        }

        .btn-price {
            display: inline-block;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            padding: 14px 40px;
            -webkit-border-radius: 26px;
            -moz-border-radius: 26px;
            -o-border-radius: 26px;
            border-radius: 26px;
            border: 1px solid #848181;
            background-color: transparent;
            color: #848181;
        }

        .pricing-item:hover .btn-price,
        .active .btn-price {
            border: 1px solid #4e73df;
            background-color: #4e73df;
            color: #fff;
        }

        .btn-price:focus {
            background-color: transparent;
            text-decoration: none;
        }

        @media only screen and (max-width: 767px) {
            .pricing-items {
                padding-top: 0;
            }

            .pricing-item.active {
                top: 20px;
                margin-bottom: 40px;
            }
        }

    </style>

    <section id="counter" class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="count"> <span class="fa fa-smile-o"></span>
                        <p class="number">{{ $counters->clientes }}</p>
                        <h4>Clientes</h4>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="count"> <span class="fa fa-smile-o"></span>
                        <p class="number">{{ $counters->encomendas }}</p>
                        <h4>Encomendas</h4>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="count"> <span class="fa fa-smile-o"></span>
                        <p class="number">{{ $counters->estampas }}</p>
                        <h4>Estampas</h4>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="count"> <span class="fa fa-smile-o"></span>
                        <p class="number">{{ $counters->cores }}</p>
                        <h4>Cores</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>
    <!-- line chart canvas element -->
    <canvas id="buyers" width="1500" height="400"></canvas>
    <canvas id="countries" width="600" height="400"></canvas>
    <canvas id="income" width="600" height="400"></canvas>
    <script>
        // line chart data
        var buyerData = {
            labels: {!! json_encode(array_column($encomendasbymonthyear, 'yearmonth')) !!},
            datasets: [{
                fillColor: "rgba(172,194,132,0.4)",
                strokeColor: "#4e73df",
                pointColor: "#fff",
                pointStrokeColor: "#9DB86D",
                data: {!! json_encode(array_column($encomendasbymonthyear, 'total')) !!}
            }]
        }
        // get line chart canvas
        var buyers = document.getElementById('buyers').getContext('2d');
        // draw line chart
        new Chart(buyers).Line(buyerData);



        // var pieData = [
        //         {
        //             value: 20,
        //             color:"#878BB6"
        //         },
        //         {
        //             value : 40,
        //             color : "#4ACAB4"
        //         },
        //         {
        //             value : 10,
        //             color : "#FF8153"
        //         },
        //         {
        //             value : 30,
        //             color : "#FFEA88"
        //         }
        //     ];
            // pie chart options
            var pieOptions = {
                 segmentShowStroke : false,
                 animateScale : true
            }
            // get pie chart canvas
            var countries= document.getElementById("countries").getContext("2d");
            // draw pie chart
            new Chart(countries).Pie({!! json_encode($coresVendidas) !!}, pieOptions);


            var barData = {
                labels : {!! json_encode(array_column($tipoPagamento,'tipo_pagamento')) !!},
                datasets : [
                    {
                        fillColor : "#48A497",
                        strokeColor : "#48A4D1",
                        data : {!! json_encode(array_column($tipoPagamento, 'cont')) !!}
                    }
                ]
            }
            // get bar chart canvas
            var income = document.getElementById("income").getContext("2d");
            // draw bar chart
            new Chart(income).Bar(barData);


    </script>

@endsection
