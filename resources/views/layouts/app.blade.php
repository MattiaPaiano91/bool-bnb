<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/jpg" href="{{ asset('img/loghi/boolairbnb-favicon.PNG') }}" />
    <title>@yield('page-title') | {{ config('', 'BoolBnb') }}</title>

    <!-- Scripts -->
    @vite('resources/js/app.js')
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-bool bg-white border-bottom container-fluid">

            <div class="box-img-logo">
                <img src="{{ asset('img/loghi/boolbnb-rosa-sfondobianco-150px.JPG') }}" class=" h-100 w-100 "
                    alt="">
            </div>
            <div class="collapse navbar-collapse mx-4 " id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-5">
                        <a class="icon-link text-black text-decoration-none hov-underline"
                            href="{{ route('admin.apartments.index') }}">
                            Appartamenti
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.apartments.create') }}"
                            class="icon-link text-black text-decoration-none hov-underline">Crea un
                            Appartamento</a>
                    </li>
                </ul>
                <div>
                    <button type="button" class="btn-turn-back rounded-4" data-bs-toggle="modal"
                        data-bs-target="#my-modal">
                        Appartamenti
                        archiviati
                    </button>
                    <!-- Archivo Modal -->
                    <div class="modal fade" id="my-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Archivio BoolBnB</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                {{-- <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Img</th>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Prezzo</th>
                                                <th scope="col">Azioni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($apartments as $apartment)
                                                @if ($apartment->deleted_at != null)
                                                    <tr>

                                                        <td>
                                                            @if (!empty($apartment->full_cover_img))
                                                                <img class="card-img-top object-fit-contain "
                                                                    src="{{ $apartment->full_cover_img }}"
                                                                    alt="Cover Image">
                                                            @else
                                                                <img src="{{ asset('img/loghi/boolairbnb-favicon.PNG') }}"
                                                                    class="card-img-top object-fit-contain "
                                                                    alt="Default Cover Image">
                                                            @endif
                                                            
                                                        </td>
                                                        <td>{{ $apartment->name }}</td>
                                                        <td>{{ $apartment->price }}</td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <form class="mt-5"
                                                                    id="deleteForm{{ $apartment->slug }}"
                                                                    action="{{ route('admin.restore', ['slug' => $apartment->slug]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger"
                                                                        data-bs-target="#deleteConfirmation{{ $apartment->slug }}">
                                                                        Recupera
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="mb-1" href="{{ route('admin.dashboard') }}" class="">
                        <button class=" btn-turn-back rounded-4">
                            Torna alla Home
                        </button>
                    </a>
                </div>
                <div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn-turn-back rounded-4">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>

        </nav>
    </header>
    <main class="py-4">

        @yield('main-content')
        <!-- Icona del chat bot -->
        <div class="chat-icon" id="chatIcon">

            <img src="{{ asset('img/loghi/boolairbnb-favicon.PNG') }}" class="w-100 h-100" alt="Chat Icon">
        </div>

        <!-- Finestra della chat -->
        <div class="chat-box" id="chatBox">
            <div class="chat-header">
                <h4 class="">BoolBot</h4>
                <span class="close-btn" id="closeBtn">&times;</span>
            </div>
            <div class="chat-body">
                <div class="message received">
                    <p>Ciao sono BoolBot! Come posso aiutarti?</p>
                </div>
            </div>
            <div class="chat-footer">
                <input type="text"id="userMessage" placeholder="Scrivi un messaggio...">
                <button id="sendMessage" class="btn btn-danger rounded-4">Invia</button>
            </div>
        </div>

    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/@openai/openai-js"></script>

</html>
<style>
    .hov-underline {
        position: relative;
        display: inline-block;
        font-size: 1.2 rem;
        padding-bottom: 3px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: border-color 0.3s ease;

        /* Aggiungi una transizione fluida per l'effetto hover */
        &:hover {
            transform: scale(1.1);
        }
    }

    /* Animazione per la sottolineatura */
    .hov-underline::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        /* Inizia senza larghezza */
        height: 2px;
        /* Altezza della sottolineatura */
        background-color: #EB5A63;
        transition: width 0.3s ease;
        /* Aggiungi una transizione fluida per l'animazione */
        transform: scale(1.1);
    }

    .hov-underline:hover::after {
        width: 100%;
        /* Espandi la larghezza al 100% durante l'hover */

    }

    .chat-icon {
        height: 60px;
        width: 60px;
        border: 1px solid #EB5A63;
        border-radius: 50%;
        position: fixed;
        bottom: 20px;
        right: 20px;
        cursor: pointer;

    }

    @keyframes chatIconAnimation {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .chat-icon img {
        animation: chatIconAnimation 2s infinite;
    }

    h4 {
        color: #EB5A63;
    }

    .chat-box {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
        overflow: hidden;
        display: none;
    }

    .chat-header {
        background-color: #f1f1f1;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-btn {
        cursor: pointer;
    }

    .chat-body {
        height: 200px;
        overflow-y: auto;
        padding: 10px;
    }

    .message {
        margin-bottom: 10px;
    }

    .received {
        background-color: white;
        padding: 5px;
        border-radius: 5px;
        max-width: 70%;
    }

    .chat-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border-top: 1px solid #ccc;
    }

    #userMessage {
        flex-grow: 1;
        margin-right: 10px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatIcon = document.getElementById('chatIcon');
        const chatBox = document.getElementById('chatBox');
        const closeBtn = document.getElementById('closeBtn');
        const userMessage = document.getElementById('userMessage');
        const sendMessageBtn = document.getElementById('sendMessage');
        const chatBody = document.querySelector('.chat-body');

        chatIcon.addEventListener('click', function() {
            chatBox.style.display = 'block';
        });

        closeBtn.addEventListener('click', function() {
            chatBox.style.display = 'none';
        });

        sendMessageBtn.addEventListener('click', function() {
            const message = userMessage.value.trim();

            if (message !== '') {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message sent';
                messageDiv.innerHTML = `<p>${message}</p>`;
                chatBody.appendChild(messageDiv);

                // Simulazione della risposta del bot
                setTimeout(function() {
                    const replyDiv = document.createElement('div');
                    replyDiv.className = 'message received';
                    replyDiv.innerHTML =
                        '<p>Contatteremo immediatamente il nostro team di sviluppo e risolveremo il problema il prima possibile ci scusiamo per il disagio</p>';
                    chatBody.appendChild(replyDiv);
                }, 1000);

                userMessage.value = ''; // Pulisce l'input
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const chatIcon = document.getElementById('chatIcon');
        const chatBox = document.getElementById('chatBox');
        const closeBtn = document.getElementById('closeBtn');

        // Mostra la chat box e nasconde l'icona del chat bot
        chatIcon.addEventListener('click', function() {
            chatBox.style.display = 'block';
            chatIcon.style.display = 'none'; // Nasconde l'icona del chat bot
        });

        // Nasconde la chat box e mostra di nuovo l'icona del chat bot
        closeBtn.addEventListener('click', function() {
            chatBox.style.display = 'none';
            chatIcon.style.display = 'block'; // Mostra di nuovo l'icona del chat bot
        });
    });
</script>
