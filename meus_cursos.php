<?php
    //Mantendo a sessão/cria uma sessao
session_start();

if(!isset($_SESSION["system_control"]))
{
  ?>
  <script>
    alert("Acesso Inválido!");
    document.location.href = "login.php";
  </script>
  <?php
}
else{
        //Sessao já criada
        //Recuperando as variaveis da sessão
  $system_control = $_SESSION["system_control"];
  $cod_login = $_SESSION['cod_login'];
  $privilegio = $_SESSION["privilegio"];
  $cod_cliente = $_SESSION["cod_cliente"];

  if($system_control == 1 && $privilegio == 0){
    require('connect.php');

    $sql_pesquisa ="SELECT * FROM `cliente` WHERE `cod_login` = $cod_login" ;
    $resultado = mysqli_query($conn,$sql_pesquisa);
    $vetor = mysqli_fetch_array($resultado);

    $sql ="SELECT * FROM `login` WHERE `cod_login` = $cod_login" ;
    $resultado_pesquisa = mysqli_query($conn,$sql);
    $vetor_login = mysqli_fetch_array($resultado_pesquisa);

    $sql_curso ="SELECT * FROM `curso` WHERE `cod_cliente` = $cod_cliente" ;
    $curso_resultado = mysqli_query($conn,$sql_curso);
    $numero_cursos = mysqli_num_rows($curso_resultado);
    $_SESSION["nome"] = $vetor["nome"];
    ?>
    ?>

    <!DOCTYPE html>
    <html>

    <head>
      <title>Meus Cursos</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS CDN -->
      <link rel="stylesheet" href="scss/main.css">
      <link rel="stylesheet" href="css/chat.css">
      <!-- Our Custom CSS -->
      <link rel="stylesheet" type="text/css" href="css/style.css">


    </head>

    <body style="overflow-x: hidden;">


      <?php
      require("navbar_cliente.html");
      ?>
      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
              <ul class="nav flex-column">
                <br>
                <li class="nav-item">
                  <a class="nav-link active" href="#" style="color: #ff0000">
                    <span data-feather="home"></span>
                    Cursos Disponíveis <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="aparecer2" href="#">Meus Cursos</a>
                </li>
                <li class="nav-item"> 
                  <a class="nav-link" href="#" id="aparecer" >Novo Curso
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" id="btnalterar" >Alterar Cursos
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" id="btnencerrar" >Encerrar Cursos
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="visualizar_cursos_aluno.php" >Cursos dos Professores
                  </a>
                </li>

              </ul>
            </div>
          </nav>

          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="row">
              <div class="col">
                <div class="row">
                  <div class="col-sm" id="escondido" style="display: none;">

                   <br>
                   <center><h4>Escolha a disciplina e as suas disponibilidades interessadas.</h4></center>
                   <form method="POST" action="cadastrar_curso_aluno.php">
                    <div class="row">
                      <div class="col-4"> Nome Completo:<input type="text" class="form-control" id="nome_completo" name="nome_completo" placeholder= "Digite seu nome completo." required></div>
                     <div class="col-4"> Definicao: <select name="definicao" class="form-control" id="definicao" required><option value="">Selecione um cargo.
                     </option><option value="Aluno">Aluno
                     </option>
                   </select></div>
                   <div class="col-4"> Disciplina: <select name="disciplina" style="" class="form-control" id="disciplina" required> <option value="">Selecione uma disciplina.
                   </option><option value="Inglês">Inglês
                   </option><option value="Espanhol">Espanhol
                   </option><option value="Francês">Francês
                   </option><option value="Japonês">Japonês
                   </option><option value="Alemão">Alemão
                   </option><option value="Polonês">Polonês
                   </option><option value="Holandês ">Holandês
                   </option><option value="Russo ">Russo
                   </option><option value="Italiano ">Italiano    
                   </option> </select> </div>
                   <div class="col-4"> Tempo do Curso: <select  class="form-control year" name="tempo_curso" id="year" required>
                    <option value="">Selecione o tempo.</option> </select> </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      Periodo:
                      <select name="periodo" class="form-control tipo" id="periodo" required>

                        <option value="Manhã">Manhã</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noite">Noite</option>


                      </select>
                    </div>
                    <div class="col-4"> Nível:<select id="nivel" name="nivel" class="form-control" required><option value="">Escolha seu nível.
                    </option><option value="Básico I">Básico I
                      </option><option value="Básico II">Básico II
                    </option><option value="Intermediário I">Intermediário I
                      </option><option value="Intermediário II">Intermediário II
                    </option><option value="Avançado I">Avançado I
                      </option><option value="Avançado II">Avançado II
                    </option> </select> </div>

                    <div class="col-4">




                    </div>
                  </div>
                  <div class="row">


                  </div>
                  <div class="row">
                    <div class="col-sm">
                      <center><br><a class="btn btn-terciary" href="login.php">Cancelar</a>
                        <button type="submit" value="0" id= "btnenviar" name="opcao" class="btn btn-danger">Enviar</button></center>
                      </form> </div>

                    </div>

                  </div>

                  <div class="col-sm" id="escondido2" style="display: block;">
                    <br>
                    <center><h4>Seus cursos interessados aparecerão na lista abaixo.</h4></center>
                    <br>
                    <ul style="text-align: left;" class="list-group">

                      <?php
                      $x = 0;
                      while ($vetor_curso = mysqli_fetch_array($curso_resultado)) {

                        echo "<li class='list-group-item itens'><p style='display:inline-block;'  class='disciplina'>Disciplina: " . $vetor_curso['disciplina']. "<br> </p><a class='aencerrar' style='display:none;' href='encerrar_curso_aluno.php?disciplina=".$vetor_curso['disciplina']."'aria-label='Close'><i class='fas fa-times close'></i></a><button value= 'edit".$x."' class='btn btn-danger aalterar' data-toggle='modal' data-target='#exampleModal".$x."' style='display:none;' href='#' aria-label='Edit'><i class='fas fa-pencil-alt edit'></i></button><br> Definição: ". $vetor_curso['definicao']." <br><br> Nível: ". $vetor_curso['nivel']." <br> <br> Nome completo: ". $vetor_curso['nome_completo']." <br> <br>   Tempo do Curso:  " . $vetor_curso['tempo_curso']. " <br> <br> Período: ".$vetor_curso['periodo']." <br> 

                        </li>


                        <div class='modal fade bd-example-modal-lg' id='exampleModal".$x."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-lg' role='document'>
                        <div class='modal-content'>
                        <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'>Altere seus cursos interessados.   Disciplina: ".$vetor_curso['disciplina']."</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>
                        <div class='modal-body'>
                        <form method='POST' action='alterar_curso_aluno.php'>
                        <div class='row'>
                       <div class='col-6'>
                        Nível:
                          <select name='nivel' class='form-control' value='".$vetor_curso['nivel']."'>
                         <option value='".$vetor_curso['nivel']."'>Selecione um nível.
                   </option><option value='Básico I'>Básico I
                   </option><option value='Básico II'>Básico II
                   </option><option value='Intermediário I'>Intermediário I 
                   </option><option value='Intermediário II'>Intermediário II
                   </option><option value='Avançado I'>Avançado I 
                   </option><option value='Avançado II'>Avançado II 
                   </option> </select>
                        </div>
                        <div class='col-6'> Tempo do Curso:
                        <select class='form-control year' name='tempo_curso' value='".$vetor_curso['tempo_curso']."'>
                        <option value='".$vetor_curso['tempo_curso']."'>Selecione o tempo.
                        </select>
                        </div>
                        </div>
                        <div class='row'>
                        <div class='col-4'>
                        Periodo:
                         <select name='periodo' class='form-control' value='".$vetor_curso['periodo']."'>
                         <option value='".$vetor_curso['periodo']."'>Selecione um periodo.
                   </option><option value='Manhã'>Manhã
                   </option><option value='Tarde'>Tarde
                   </option><option value='Noite'>Noite
                   </option> </select>
                        </div>
                        <div class='col-8'>
                        Nome Completo:
                        <input class='form-control' name='nome_completo' value='".$vetor_curso['nome_completo']."'>
                        


                        </select>
                        </div>
                       
                        <div class='col-4'>




                        </div>
                        </div>
                        <div class='row'>


                        </div>
                        <div class='row'>


                        </div>
                        </div>
                        <div class='modal-footer'>
                        <a class='btn btn-terciary' href='meus_cursos.php'>Cancelar</a>
                        <button type='submit' value='0' id= 'btnenviar' name='opcao' class='btn btn-danger'>Enviar</button>
                        </div>
                        </div></form> 
                        </div>
                        </div>

                        ";
                        $x = $x + 1 ;


                      }

                      ?>
                      <div id="cagada"></div>

                    </ul>

                  </center>
                </div>

              </div>
            </div>
          </div>

        </main>

      </div>

    </div>
  </div>
</div>

<script src="js/jquery.mask.min.js"></script>





<script>
  $(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
    });
  });
</script>
<script type="text/javascript">

  inpYear = $('#expYear'),
  html = '';

  for (var i = 1; i <= 8; i++) {

    $('.year').append($("<option></option>").attr("value", i).text( i +" anos"));
  };

  console.log(html);

</script>
<script>
  $(document).ready(function() {

  });
  $("#aparecer").click(function() {
    $("#escondido").css("display", "none");
    $("#escondido").slideDown(1000);
    $("#escondido2").css("display", "none");
    $("#alterar").css("display", "none");
    $("#nivel").val("");

  });
  $("#aparecer2").click(function() {
    $("#escondido2").css("display", "none");
    $("#escondido2").slideDown(1000);
    $("#escondido").css("display", "none");
    $("#alterar").css("display", "none");
    $(".close").css("display", "none");
    $(".aalterar").css("display", "none");
    $("#escondido3").css("display", "none");

  });

  $("#btnencerrar").click(function() {
    $("#escondido2").css("display", "none");
    $("#escondido2").slideDown(1000);
    $("#escondido").css("display", "none");
    $(".aencerrar").css("display", "inline-block");
    $(".aencerrar").css("float", "right");
    $(".aalterar").css("display", "none");
    $(".close").css("color", "red");
    $(".close").css("display", "block");
    $("#escondido3").css("display", "none");
    $("#titulo").text("Encerrar Curso");
  });
  $("#btnalterar").click(function() {
    $("#escondido2").css("display", "none");
    $("#escondido2").slideDown(1000);
    $("#escondido").css("display", "none");
    $(".aalterar").css("display", "inline-block");
    $(".aalterar").css("float", "right");
    $(".aencerrar").css("display", "none");
    $(".edit").css("color", "white");
    $(".edit").css("display", "block");
    $("#escondido3").css("display", "none");
    $("#titulo").text("Alterar Curso");
  });

  $(".btncancelar").click(function(){

    $("#escondido3").toggle(1000);
  }); 


</script>
</html>


<?php
}
else
{

  session_destroy();


  ?>
  <script>
    alert("Acesso Inválido!");
    document.location.href = "login.php";
  </script>
  <?php
}
}
?> 