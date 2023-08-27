@include('mail.parts.start')
    <p>Köszönjük, hogy érdeklődik az áruházunkban fellelhető termékek iránt és regisztrált a <a href="{{ URL::to('/') }}">{{ URL::to('/') }}</a> címen található weboldalunkra.<br/>
    Regisztrációja véglegesítéséhez kérjük kattintson az alábbi linkre:</p>
    <p><a href="{{ URL::to('/') }}/user/register/{{ $activation_code }}">Fiók aktiválása</a></p>
@include('mail.parts.end')