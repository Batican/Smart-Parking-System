<!DOCTYPE html>
<html>
<head>
    <title>DAILY Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <h1>Daily Reports</h1>
    <p></p>
    <h3 class="text-left">TOTAL OF PARKED CARS: {{$grandtotal}}</h3>
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-primary">
                <th scope="col">PARKED #</th>
                <th scope="col">Name</th>
                <th scope="col">Parking Number</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
            <tr>
                <th scope="row">{{ $car->id }}</th>
                <td>{{ $car->user->first_name }} {{$car->user->last_name}}</td>
                <td>{{ $car->parking_number }}</td>
                <td>{{ $car->date}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>