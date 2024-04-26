@extends('layouts.app')

@section('page-title', 'All apartments')

@section('main-content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fluid p-0 ">
        <div class="row">
            <h1 class="index-text px-5">
                I tuoi Appartamenti
            </h1>
            <div class="col-12 index-container px-5">
                @foreach ($apartments as $apartment)
                    @if ($apartment->deleted_at == null)
                        <div class="index-card shadow ">
                            @if (!empty($apartment->full_cover_img))
                                <div class="card-img-top">
                                    <img src="{{ $apartment->full_cover_img }}" alt="Cover Image">

                                </div>
                            @else
                                <div class="card-img-top">
                                    <img class="object-fit-contain" src="{{ asset('img/loghi/boolairbnb-favicon.PNG') }}"
                                        alt="Default Cover Image">
                                </div>
                            @endif
                            <div id="scrollbar2" class="card-body p-3">
                                <strong class="card-title">Nome appartamento:
                                    <strong>{{ $apartment->name }}</strong>
                                </strong>
                                <p class="card-text">
                                    <strong>Tipo di Struttura:</strong>
                                    {{ $apartment->type_of_accomodation }} <br>
                                    <strong>Indirizzo:</strong> {{ $apartment->address }} <br>
                                    <strong>Sponsorizzato:</strong>
                                    @if ($apartment->sponsorships->isNotEmpty())
                                        @foreach ($apartment->sponsorships as $sponsorship)
                                            {{ $sponsorship->title }} - Scadenza:
                                            {{ $sponsorship->pivot->end_date }} <br>
                                        @endforeach
                                    @else
                                        Sponsor non attiva <br>
                                    @endif
                                    <strong>Disponibile:</strong>
                                    @if ($apartment->availability == 1)
                                        <i class="fa-solid fa-check" style="color: #18b215;"></i>
                                    @else
                                        <i class="fa-solid fa-x" style="color: #ed1707;"></i>
                                    @endif
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between p-0">

                                <div>
                                    <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}"
                                        class="btn btn-link" title="Visualizza">
                                        <i class="fa-solid fa-eye fa-xl" style="color: #000000;"></i>
                                    </a>

                                    <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->slug]) }}"
                                        class="btn btn-link" title="Modifica"><i class="fa-solid fa-pencil fa-xl"></i>
                                    </a>

                                    <button type="button" class="btn btn-link text-decoration-none " title="Messaggi">
                                        <a class="position-relative w-25"
                                            href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}">
                                            @if ($apartment->unreadMessagesCount() > 0)
                                                <i class="fa-solid fa-envelope fa-xl " style="color: #0c2c64;"></i>
                                                <span class="counter-email">{{ $apartment->unreadMessagesCount() }}</span>
                                            @else
                                                <i class="fa-solid fa-envelope-open fa-xl" style="color: #0c2c64;"></i>
                                            @endif
                                        </a>
                                    </button>
                                </div>

                                <button type="button" class="btn btn-link" title="Archivia" data-bs-toggle="offcanvas"
                                    data-bs-target="#deleteConfirmation{{ $apartment->id }}"><i
                                        class="fa-solid fa-trash-can fa-xl" style="color: #ff470a;"></i>
                                </button>
                                <div class="offcanvas offcanvas-end " tabindex="-1"
                                    id="deleteConfirmation{{ $apartment->id }}">
                                    <div class="offcanvas-header">
                                        <h5 class="offcanvas-title" id="deleteConfirmationLabel{{ $apartment->id }}">
                                            Conferma archiviazione
                                        </h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <p>Vuoi realmente archiviare questo appartamento?
                                        <h5 class=" d-inline-block ">{{ $apartment->name }}</h5> ?
                                        </p>
                                        <form class="mt-5" id="deleteForm{{ $apartment->slug }}"
                                            action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->slug]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Conferma
                                                archiviazione
                                            </button>
                                        </form>
                                    </div>
                                </div>



                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
        
    </div>



@endsection
