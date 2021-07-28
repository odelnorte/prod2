<?php
include("../../Conexion/conectaBase.php");

$sd =new conexion();
$sd->conectar();

$regx=mssql_query("select * from cregion where regionid!=9 order by nombre");
$salax=mssql_query("select * from csala where regionidfk=1 and estatusidfk=5 order by nombre"); 
$region="<select id='selectRegionMaq' onChange='traedatosMaqRep(this.value,3,0);'>";
	 $region=$region."<option value='%'>Todas</option>";
	 while($row = mssql_fetch_array($regx)) 
	 {$region=$region."<option value='".$row["regionid"]."'>".$row["nombre"]."</option>";}
	  $region=$region."</select>";
$sala="<span id='spanSala'><select id='selectSalaMaq'>";
	  $sala=$sala."<option value='%' >Todas</option>";
	  while($row2 = mssql_fetch_array($salax)) 
	 {$sala=$sala."<option value='".$row2["salaid"]."' >".$row2["nombre"]."</option>";}
	  $sala=$sala."</select></span>";
?>

<div id="divReporteMaquinas" style="width:100%">
<div id="menuRepMaq">Serie: <input id="inputSerieMaq" type="text" size="7">&nbsp;&nbsp;&nbsp;
	Ubicacion: <select id="selectUbicacionMaq" onChange="traeDatosRM(this.value);"><option value="%">Todas</option><option value="Bodega">Bodega</option><option value="Sala">Sala</option><option value="Transito">Transito</option><option value="A DESTRUIR">A Destruccion</option><option value="varias">Varias</option></select>&nbsp;&nbsp;
	<span id="spanDatosSala" style="display:none;"><?php echo"Region: ". $region."&nbsp;&nbsp;Sala: ".$sala ?></span>
    <span id="spanDatosBod" style="display:none;">
    	<select id="selectBodegaRepMaqs" onChange="traedatosMaqRep(this.value,1,0);"><option value="%">Todas</option><option value="Bodega 2">2</option><option value="Bodega 5">5</option><option value="Bodega 9">9</option><option value="Bodega 102">102</option><option value="Bodega 1">1</option></select>&nbsp;&nbsp;Rack: 
    <span id="spanRackRepMaqs"><select id="selectRackRepMaqs" onChange="traedatosMaqRep(this.value,2,selectBodegaRepMaqs.value);"><option value="%">Todos</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
    </span>&nbsp;&nbsp;
    Nivel: <span id="spanNivelRepMaqs"><select id="selectNivelRepMaqs"><option value="%">Todos</option><option value="1">1</option><option value="2">2</option></select></span></span><br><br>
    Pedimento: <input id="inputPedimentoMaq" type="text" size="9">&nbsp;&nbsp;&nbsp;
    Factura: <input id="inputFacturaMaq" type="text" size="9">&nbsp;&nbsp;&nbsp;<input id="BotonBRM" type="button" value="Buscar" onClick="buscaMaquinas2();">&nbsp;&nbsp;&nbsp;<span id="spanNumMaq"></span>&nbsp;&nbsp;&nbsp;<span id="spanExportarPDF"></span>&nbsp;&nbsp;&nbsp;<span id="spanExportarExcel"></span>
</div>
<div id="busquedaMaqRepMaqs"></div>
</div>

<?php $sd->desconectar(); ?>