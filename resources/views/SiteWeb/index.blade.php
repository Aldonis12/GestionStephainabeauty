<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STEPHAINA BEAUTY</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/cssSiteWeb/styles.css') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logoSB.svg') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    @include('contenuSite.header')

    @if ($titre == 'Accueil')
        <div class="content">
            <div class="carousel" id="carousel">
                @foreach ($actualites as $actualite)
                    <img class="img-content" src="{{ $actualite->image64 }}" />
                @endforeach
            </div>
        </div>

        <div id="service">
            <div class="content-titre">
                <div class="text">
                    <h3 class="active">Service</h3>
                    <p>
                        Bienvenue dans notre oasis de beauté, où chaque détail est conçu
                        pour révéler votre éclat naturel.
                    </p>
                </div>
                <br />
            </div>

            <div class="carouselbe">
                <div class="carousel-inner">
                    @foreach ($services as $service)
                        <div class="carousel-item">
                            <div class="card">
                                <img src="{{ $service->image64 }}" alt="Image Alt Text">
                                <div class="card-content">
                                    <h3>{{ $service->nom }}</h3>
                                    <br>
                                    <p>{{ $service->description }}</p>
                                    <br>
                                    <button>Voir prix</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button id="prevBtn" style="display: none;"></button>
            <button id="nextBtn" style="display: none;"></button>
        </div>

        <div class="imageres">
            <div class="sary">
                <img src="{{ $imageRes->image64 }}" alt="Sary Res">
            </div>
            <div class="soratra">
                <p class="soratrabe">We are delighted <br> to welcome <br> you</p>
                <div class="ligne"></div>
                <p class="soratrakely">Pour une expérience de beauté <br> inoubliable.<br> <span
                        style="color: rgb(2, 27, 250); cursor: pointer;">réserver votre rendez-vous dès
                        maintenant</span></p>
            </div>
        </div>

        <br />
        <div class="content-titre">
            <div class="text">
                <h3 class="active">Localisation</h3>
                <p>Trouvez le salon Stephaina Beauty le plus proche de chez vous.</p>
            </div>
            <br>
            <div class="buttons-and-map">
                <div class="buttons">
                    <ul class="salon-list">
                        @foreach ($salons as $salon)
                            <li>
                                <button
                                    onclick="showLocation('{{ $salon->localisation }}')">{{ ucfirst($salon->nom) }}</button>
                            </li>
                        @endforeach
                    </ul>
                    <br><br>
                </div>
                <div class="map">
                    <div id="map-container" class="mape">
                        <iframe id="map-iframe"
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1036597.8018230407!2d48.19936338678438!3d-18.44666105939274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2smg!4v1697574272496!5m2!1sfr!2smg"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($titre == 'Service')
        <div class="content">
            <div class="carousel" id="carousel">
                <img class="img-content" src="{{ $imageplan->image64 }}" />
            </div>
        </div>

        <div class="contenu">
            <div class="text">
                <h3 class="active">Les services</h3>
                <p>Veuillez cliquer sur un service pour voir ses prix.</p>
            </div>
            <br />
            <div class="card-container">
                @foreach ($services as $service)
                    <div class="cardkely" onclick="window.location.href = '/PriceService/'+{{ $service->id }}">
                        <img src="{{ $service->image64 }}" alt="Image Alt Text" />
                        <div class="card-contentserv">
                            <h3>{{ $service->nom }}</h3>
                            <p>
                                {{ $service->description }}
                            </p>
                            <br />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($titre == 'PrixService')

        <div class="ombre-de-ligne">
        </div>
        <div class="text">
            <h3 class="active">{{ strtoupper($service->nom) }} <span
                    onclick="window.location.href = '/Service'" class="revenir">/ Revenir à la liste</span>
            </h3>
        </div>
        <br />

        <div class="container-prix">
            <button id="toggleCurrency" class="currency-button" onclick="toggleCurrency()">Prix : Euro</button>
            @foreach ($categories as $category)
                <div class="category">
                    <span class="nomService">{{ ucfirst(strtolower($category->nom)) }}</span>
                    @if ($category->prix > 0)
                        <div class="line"></div>
                        <span class="prixService">{{ $category->prix }} Ar</span>
                    @endif
                </div>
                @if ($category->description != '')
                    <div class="descriptionService">
                        {{ $category->description }}
                    </div>
                @endif

                @foreach ($subcategories as $subcategory)
                    @if ($subcategory->idservicecategorie == $category->id)
                        <div class="subcategory">
                            <span class="nomSubService">{{ ucfirst(strtolower($subcategory->nom)) }}</span>
                            @if ($subcategory->prix > 0)
                                <div class="line"></div>
                                <span class="prixService">{{ $subcategory->prix }} Ar</span>
                            @endif
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>




    @endif
    <br /><br />

    @include('contenuSite.footer')
</body>

</html>


<script>
    let currentCurrency = 'Ar';
    const pricesInAriary = Array.from(document.querySelectorAll('.prixService'), price => price.textContent);

    function toggleCurrency() {
        const prices = document.querySelectorAll('.prixService');
        const currencyButton = document.getElementById('toggleCurrency');

        if (currentCurrency === 'Ar') {
            prices.forEach((price, index) => {
                const euroPrice = convertToEuro(pricesInAriary[index]);
                price.textContent = euroPrice + ' €';
            });
            currencyButton.textContent = 'Prix : Ariary';
            currentCurrency = 'Euro';
        } else {
            prices.forEach((price, index) => {
                price.textContent = pricesInAriary[index];
            });
            currencyButton.textContent = 'Prix : Euro';
            currentCurrency = 'Ar';
        }
    }

    function convertToEuro(priceAr) {
        return (parseFloat(priceAr) / 4500).toFixed(2);
    }
</script>


<script>
    const carousel = document.querySelector(".carousel");
    const images = carousel.querySelectorAll(".img-content");
    let currentIndex = 0;

    function slide() {
        currentIndex++;
        if (currentIndex >= images.length) {
            currentIndex = 0;
        }
        const offset = -currentIndex * 33.33;
        carousel.style.transition = "transform 1s ease-in-out";
        carousel.style.transform = `translateX(${offset}%)`;
    }
    setInterval(slide, 5000);
</script>

<script>
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const carouselInner = document.querySelector(".carousel-inner");

    let currentIndexbe = 0;

    nextBtn.addEventListener("click", () => {
        currentIndexbe += 1;
        if (currentIndexbe > 4) {
            currentIndexbe = 0;
        }
        updateCarousel();
    });

    prevBtn.addEventListener("click", () => {
        currentIndexbe -= 1;
        if (currentIndexbe < 0) {
            currentIndexbe = 4;
        }
        updateCarousel();
    });

    function updateCarousel() {
        const itemWidth = 33.33;
        const offset = currentIndexbe * -itemWidth;
        carouselInner.style.transform = `translateX(${offset}%)`;
    }

    setInterval(() => {
        currentIndexbe += 1;
        if (currentIndexbe > 4) {
            currentIndexbe = 0;
        }
        updateCarousel();
    }, 3000);
</script>

<script>
    function showLocation(url) {
        const mapContainer = document.getElementById("map-container");
        mapContainer.innerHTML =
            `<iframe src="${url}" id="map-iframe" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
    }

    function scrollToContent(targetId) {
        const element = document.getElementById(targetId);
        if (element) {
            element.scrollIntoView({
                behavior: "smooth"
            });
        }
    }
</script>
