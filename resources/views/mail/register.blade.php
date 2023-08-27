@include('mail.parts.start')
    <p>Köszönjük, hogy érdeklődik az áruházunkban fellelhető termékek iránt és regisztrált a <a href="{{ route('home') }}">{{ route('home') }}</a> címen található weboldalunkra.<br/>
    Regisztrációja véglegesítéséhez kérjük kattintson az alábbi linkre:</p>
    <p><a href="{{ route('register_activate', $activation_code) }}">Fiók aktiválása</a></p>
@include('mail.parts.end')