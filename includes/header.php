<nav class="navbar navbar-expand px-3 border-bottom" style="background-color: #f9f9f9;">
    <div id="sidebar-toggle">
        <p class="h6" style="color:#010e17;">CrediManager <?php switch ($view) {
		case "inicio":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Inicio</spans>";
			break;
		case "gestionar":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Gestionar</spans>";
			break;
		case "consultas":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Consultas</spans>";
			break;
		case "ventas":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Ventas</spans>";
			break;
		case "usuarios":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Usuarios</spans>";
			break;
		case "metas":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Metas Individuales</spans>";
			break;
		case "metasfv":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Metas Fuerza de Ventas</spans>";
			break;
		case "cartera":
			echo "<spans class='fw-bold' style='color: #d72324;'>>> Cartera de Clientes</spans>";
			break;
		default:
			echo "<h2></h2>";
			break;
	} ?></p>
    </div>
    <div class="navbar-collapse navbar">
        <ul class="navbar-nav me-3">
            <div class="h7" style="color:#010e17;"><i class="fa-solid fa-house"></i> / Inicio</div>
        </ul>
    </div>
</nav>
