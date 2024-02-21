<section class="container">
  <footer class="page-footer">
    <p>
      &copy; <span id="date"></span>
      <span class="footer-logo">SimplyRecipes</span> Built by
    <div class="text-center p-3">
      © 2024 Copyright:
      <a class="text-dark" href="">jet 3</a>
    </div>
    </p>
  </footer>
  <script src="../final/js/app.js"></script>
</section>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
  integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).ready(function () {
    console.log('je suis dans les likes 1');
    // Fonction pour gérer le clic sur le bouton "like"
    $('.like-btn').click(function () {
                console.log('je suis dans les likes 2');
                var recetteId = $(this).data('id');

                $.ajax({
                    url: 'toggle_like.php', // Le script PHP qui gérera le "like"
                    type: 'POST',
                    data: {
                        'id_recette': recetteId,
                        'id_user': <?php echo $_SESSION['LOGGED_USER']['user_id']; ?>// Supposons que l'ID de l'utilisateur est stocké dans $_SESSION['user_id']
                    },
                    success: function (data) {
                        var result = JSON.parse(data);
                        $('.like-count[data-id="' + recetteId + '"]').text(result.newLikeCount); // Mise à jour du nombre de "likes"
                    }
                });
            });
  });
</script>
<script src="../final/js/content.js"></script>