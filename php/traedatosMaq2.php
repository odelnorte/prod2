<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$valor=$_POST["valorx"];
$dato=$_POST["datox"];
if($dato=='1'){$rackx=mssql_query("select distinct convert(int,rack)rack from cubicacion2 where bodega='".$valor."'order by rack");
	echo"<select id='selectRackRepMaqs' onChange='traedatosMaqRep(this.value,2,selectBodegaRepMaqs.value);'><option value='%'>Todos</option>";
	while($row = mssql_fetch_array($rackx)) 
	 {echo"<option value='".$row["rack"]."' >".$row["rack"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='2'){$bod=$_POST["bodx"];
$nivelx=mssql_query("select distinct convert(int,nivel)nivel from cubicacion2 where bodega='".$bod."' and rack like '".$valor."' order by nivel");
	echo"<select id='selectNivelRepMaqs' title='selectNivel'><option value='%'>Todos</option>";
	while($row = mssql_fetch_array($nivelx)) 
	 {echo"<option value='".$row["nivel"]."' >".$row["nivel"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='3'){
$salax=mssql_query("select * from csala where regionidfk like '".$valor."' and estatusidfk=5 order by nombre");
	echo"<select id='selectSalaMaq'>";
	echo"<option value='%' >Todas</option>";
	while($row = mssql_fetch_array($salax)) 
	 {echo"<option value='".$row["salaid"]."' >".$row["nombre"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='4'){$rackx=mssql_query("select distinct convert(int,rack)rack from cubicacion2 where bodega='".$valor."'order by rack");
	echo"<select id='selectRackDes' onChange='traedatosMaq2(this.value,5,selectBodegaDes.value);'>";
	while($row = mssql_fetch_array($rackx)) 
	 {echo"<option value='".$row["rack"]."' >".$row["rack"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='5'){$bod=$_POST["bodx"];
$nivelx=mssql_query("select distinct convert(int,nivel)nivel from cubicacion2 where bodega='".$bod."' and rack=".$valor." order by nivel");
	echo"<select id='selectNivelDes' title='selectNivelDes'>";
	while($row = mssql_fetch_array($nivelx)) 
	 {echo"<option value='".$row["nivel"]."' >".$row["nivel"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
$sd->desconectar();
?>