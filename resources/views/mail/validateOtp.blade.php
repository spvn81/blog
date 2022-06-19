<!DOCTYPE html>
<html>
<head>

</head>
<body>

    @if(!empty( $msg['title']))
    <h2> {{ $msg['title'] }}</h2>
    @endif


    @if(!empty( $msg['otp']))
    <p>Otp: {{ $msg['otp'] }}</p>
    @endif

    @if(!empty( $msg['link']))
    <p>Link: {{ $msg['link'] }}</p>
    @endif




</body>
</html>
