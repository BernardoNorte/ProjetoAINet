@extends('template.layout')
@section('title', 'Statistics')

@section('main')
    <div class="container">
        <h1>Orders By Status</h1>
        <canvas id="myChart"></canvas>
    </div>
    <div class="container">
        <h1>Orders By Year</h1>
        <canvas id="myChart2"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var chart = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(chart, {
            type: 'bar',
            data: {
                labels: {!! json_encode($years) !!},
                datasets: [{
                    label: 'Orders by Year',
                    data: {!! json_encode($totalOrders) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        var chart = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(chart, {
            type: 'bar',
            data: {
                labels: {!! json_encode($status) !!},
                datasets: [{
                    label: 'Orders by Status',
                    data: {!! json_encode($totalOrdersByStatus) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
