<?php
include('../templates/header.php');
?>

<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="../assets/img/profil-banner.png" alt="Bannière Connexion" class="absolute inset-0 w-full h-full object-cover">
    <!-- Superposition sombre et texte centré -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center leading-tight">
        Bienvenue à SoumAfrique - Connectez-vous ou Inscrivez-vous
      </h1>
    </div>
  </div>
</section>


<section class="flex w-screen mt-10 mb-10">
  <div class="m-auto">
    <section class="border bg-gray-50">
      <div class="w-[400px] sm:w-[500px] lg:w-[600px] mx-auto space-y-6 p-6 shadow-lg">
        <!-- Formulaire Connexion/Inscription -->
        <div id="form-container" class="space-y-8">
          <!-- Connexion -->
          <div id="login-form" class=" p-8 rounded-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Connexion</h2>
            <form>
              <!-- Email -->
              <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Adresse Email</label>
                <div class="flex items-center border border-gray-300 rounded-lg">
                  <i class="fas fa-envelope text-gray-500 px-3"></i>
                  <input
                    type="email"
                    placeholder="Entrez votre email"
                    class="flex-grow py-3 px-4 focus:outline-none rounded-r-lg"
                  />
                </div>
              </div>
              <!-- Mot de passe -->
              <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Mot de passe</label>
                <div class="flex items-center border border-gray-300 rounded-lg">
                  <i class="fas fa-lock text-gray-500 px-3"></i>
                  <input
                    type="password"
                    placeholder="Entrez votre mot de passe"
                    class="flex-grow py-3 px-4 focus:outline-none rounded-r-lg"
                  />
                </div>
              </div>
              <!-- Lien "Mot de passe oublié" -->
              <div class="mb-6 text-right">
                <a href="#" class="text-red-700 font-bold text-sm">Avez-vous oublié votre mot de passe ?</a>
              </div>
              <!-- Bouton de connexion -->
              <button type="submit" class="btn-gradient w-full py-3 px-6 rounded-lg font-bold">Connexion</button>
            </form>
            <!-- Lien pour passer à l'inscription -->
            <p class="text-center mt-6">
              <span class="text-gray-700">Vous n'avez pas de compte ? </span>
              <a href="#" id="switch-to-signup" class="text-red-700 font-bold">Inscrivez-vous</a>
            </p>
          </div>

          <!-- Inscription -->
          <div id="signup-form" class=" p-8 rounded-lg hidden">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Inscription</h2>
            <form>
              <!-- Nom complet -->
              <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Nom complet</label>
                <div class="flex items-center border border-gray-300 rounded-lg">
                  <i class="fas fa-user text-gray-500 px-3"></i>
                  <input
                    type="text"
                    placeholder="Entrez votre nom complet"
                    class="flex-grow py-3 px-4 focus:outline-none rounded-r-lg"
                  />
                </div>
              </div>
              <!-- Email -->
              <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Adresse Email</label>
                <div class="flex items-center border border-gray-300 rounded-lg">
                  <i class="fas fa-envelope text-gray-500 px-3"></i>
                  <input
                    type="email"
                    placeholder="Entrez votre email"
                    class="flex-grow py-3 px-4 focus:outline-none rounded-r-lg"
                  />
                </div>
              </div>
              <!-- Mot de passe -->
              <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Mot de passe</label>
                <div class="flex items-center border border-gray-300 rounded-lg">
                  <i class="fas fa-lock text-gray-500 px-3"></i>
                  <input
                    type="password"
                    placeholder="Créez un mot de passe"
                    class="flex-grow py-3 px-4 focus:outline-none rounded-r-lg"
                  />
                </div>
              </div>
              <!-- Bouton d'inscription -->
              <button type="submit" class="btn-gradient w-full py-3 px-6 rounded-lg font-bold">Inscription</button>
            </form>
            <!-- Lien pour revenir à la connexion -->
            <p class="text-center mt-6">
              <span class="text-gray-700">Vous avez déjà un compte ? </span>
              <a href="#" id="switch-to-login" class="text-red-700 font-bold">Connectez-vous</a>
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>

<!-- Script pour basculer entre les formulaires -->
<script>
  document.getElementById("switch-to-signup").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("login-form").classList.add("hidden");
    document.getElementById("signup-form").classList.remove("hidden");
  });

  document.getElementById("switch-to-login").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("signup-form").classList.add("hidden");
    document.getElementById("login-form").classList.remove("hidden");
  });
</script>



<?php
include('../templates/footer.php');
?>
