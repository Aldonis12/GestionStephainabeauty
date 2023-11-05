<footer class="footer" id="contact">
    <div class="container">
      <div class="row">
        <div class="footer-col">
          <h4>Option</h4>
          <ul>
            <li><a href="/Home">Acceuil</a></li>
            <li><a href="/Service">Service</a></li>
            <li><a href="">Reservation</a></li>
            <li><a href="">A propos</a></li>
            <li><a href="">Politique de confidentialité</a></li>
            <br>
            <li><a onclick="openForm()" style="cursor: pointer;"><i class="fas fa-globe-africa"></i> Language : Français</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Ouverture</h4>
          <p><i class="fas fa-calendar-alt"></i> Du lundi au Samedi</p>
          <br>
          <p><i class="fas fa-clock"></i> De 08:30 - 17:30</p>
          <br>
          <p><i class="fas fa-cloud-moon"></i> Shift night <br><strong>Ivandry</strong> Jeudi au Samedi : 17:30 - 22:00</p>
        </div>
        <div class="footer-col">
          <h4>Contact</h4>
          <ul>
            @foreach($contacts as $contact)
            <li>{{ucfirst($contact->nomSalon)}} : {{$contact->contact}}</li>
            @endforeach
          </ul>
        </div>
        <div class="footer-col">
          <h4>Retrouvez nous</h4>
          <div class="social-links">
            <a href="https://www.facebook.com/stephainabeauty"><i class="fab fa-facebook-f"></i></a>
            <a href="https://instagram.com/stephaina_beauty?igshid=MzRlODBiNWFlZA=="><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>Copyright &copy;2023 All reserved by <img src="{{ asset('assets/images/logoSBblanc.svg') }}" style="margin-bottom: -10px;"></p>
        
      </div>
    </div>
  </footer>

  <div class="form-popup" id="myForm" style="display : none;">
      <form action="/action_page.php" class="form-container">
          <span class="close-button" onclick="closeForm()">&times;</span>
        <h2>Langue</h2>
        <br>
        <select class="custom-select">
          <option value="fr">Français</option>
          <option value="en">English</option>
        </select>
        <button type="submit" class="btn primary-btn">Changer</button>
      </form>
  </div>

  <script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
      }
      
      function closeForm() {
        document.getElementById("myForm").style.display = "none";
      }
    </script>