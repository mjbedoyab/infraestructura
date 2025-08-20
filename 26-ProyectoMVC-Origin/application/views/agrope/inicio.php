<?php 
  $dataHeader['titulo'] = "INICIO";
  $this->load->view('layoutss/header', $dataHeader); 
?>
  <?php 
    $dataSidebar['session'] = $session;
    $dataSidebar['optionSelected'] = '';
    $this->load->view('layoutss/sidebar', $dataSidebar); 
  ?>
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper d-flex flex-column justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
  
  <!-- Emoji animado -->
  <span style="font-size:60px; display:inline-block; animation: wave 1s infinite;">👋</span>
  
  <h2 class="text-primary text-center mt-3">BIENVENIDO USUARIO DE AGROPECUARIO</h2>
  <h3 class="text-primary text-center">
    <?= explode(" ", $session['nombres'])[0]." ".explode(" ", $session['apellidos'])[0] ?>
  </h3>
</div>

<style>
@keyframes wave {
  0%   { transform: rotate(0deg); }
  15%  { transform: rotate(14deg); }
  30%  { transform: rotate(-8deg); }
  45%  { transform: rotate(14deg); }
  60%  { transform: rotate(-4deg); }
  75%  { transform: rotate(10deg); }
  100% { transform: rotate(0deg); }
}
</style>
<?php 
  $this->load->view('layoutss/footer'); 
?>
