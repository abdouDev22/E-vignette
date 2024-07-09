@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image1">
    <input type="file" name="image2">
    <button type="submit">Envoyer</button>
</form>

@if (isset($parsedText1))
    <div class="alert alert-success">
        <p>Texte analysé pour la première image :</p>
        <pre>{{ $parsedText1 }}</pre>
    </div>
@endif

@if (isset($parsedText2))
    <div class="alert alert-success">
        <p>Texte analysé pour la deuxième image :</p>
        <pre>{{ $parsedText2 }}</pre>
    </div>
@endif

@if (isset($imagePath1))
    <div>
        <img src="{{ asset('storage/' . $imagePath1) }}" alt="Uploaded Image 1">
    </div>
@endif

@if (isset($imagePath2))
    <div>
        <img src="{{ asset('storage/' . $imagePath2) }}" alt="Uploaded Image 2">
    </div>
@endif
